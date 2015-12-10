<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TPhotosTronconsErdf;


class TPhotosTronconsErdfService{
    
    // doctrine
    private $db;

    // normalizer
    private $normalizer;

    // geometrie service ** Utils **
    private $geometryService;

    
    public function __construct($db, $normalizer, $geometryService){
        $this->db = $db;
        $this->norm = $normalizer;
        $this->geometryService = $geometryService;
    }
     /* ------------ VUE LISTE ---------------
     * Retourne la liste de toutes les photos
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    public function getList($idInventaireTronconErdf=null){
       
        $repo = $this->db->getRepository('PNVCablesBundle:View\TPhotosTronconsErdfView');
        $infos = $repo->findBy(array('id_inventaire_troncon_erdf'=>$idInventaireTronconErdf));  
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = $this->norm->normalize($info, array('inventaireTronconErdf'));
            $out_item['cat'] = 'photostronconserdf';
            $out_item['cheminPhoto'] = $info->getCheminPhoto();
            $out_item['commentaire']= $info->getCommentaire();
            $out_item['neutralise']= $info->getNeutralise();
            $out_item['auteur']= $info->getAuteur();
            $out_item['id_inventaire_troncon_erdf']= $info->getIdInventaireTronconErdf();
            $out[] = $out_item;
        }

        return $out;
    }

    public function getListPhotos(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TPhotosTronconsErdfView');
        $infos = $repo->findAll();
        $out = array();
       // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'photostronconserdf',
                    'id'=>$info->getId(),
                    'cheminPhoto'=>$info->getCheminPhoto(),
                    'commentaire'=>$info->getCommentaire(),
                    'neutralise'=>$info->getNeutralise(),
                    'auteur'=>$info->getAuteur(),
                    'inventaire_troncon_erdf'=>!is_null($info->getInventaireTronconErdf())? $info->getInventaireTronconErdf()->getId(): 'null',
                );
                $out[] = $out_item;
            }
            return $out;
    }
    /* ------------ VUE UNIQUE ---------------
     *  Retourne le cas sélectionné selon l'id fourni
     *  paramètre: 
     *      id: l'id du cas
     *      findOneById: liste un cas selon son id
     */
    public function getOne($id){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TPhotosTronconsErdfView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }

        $out_item = $this->norm->normalize($info, array('inventaireTronconErdf'));
        $out_item['cheminPhoto']= $info->getCheminPhoto();
        $out_item['commentaire']= $info->getCommentaire();
        $out_item['neutralise']= $info->getNeutralise();
        $out_item['auteur']= $info->getAuteur();
        $out_item['inventaire_troncon_erdf']= !is_null($info->getInventaireTronconErdf())? $info->getInventaireTronconErdf()->getId():'';
        return $out_item;
    }
    /* ------------ CREATION ---------------
     *  Crée un nouveau cas de mortalité avec les données fournies et retourne son ID
    paramètres:
     *      id: l'ID du cas à créer
     *      data: dictionnaire de données
     *  return:
     *      {id: retourne l'id du cas crée}
     *  erreurs:
     *      DataObjectException si les données sont invalides
     */
    public function create($data){
        // print_r($data);
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        $errors = array();

        $photosTroncons = new TPhotosTronconsErdf();
    
        try{
            $this->hydrate($photosTroncons, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }

        $manager->persist($photosTroncons); // on demande à doctrine gérer l'objet $photosTroncons (il ne crée pas encore la requête dans la base de données)
        $manager->flush(); // et ici, Doctrine regarde tous les objets qu'il gère et exécute uniquement cette requête préparée à chaque fois
        $manager->getConnection()->commit();
        return array('id'=>$photosTroncons->getId());

    }
    /* ------------ MISE A JOUR ---------------
     *  Met à jour avec les données fournies et retourne son ID
     *  paramètres:
     *      id: l'ID du cas à modifier
     *      data: dictionnaire de données
     *  return:
     *      {id: retourne l'id du cas modifié}
     *  erreurs:
     *      DataObjectException si les données sont invalides
     */

    public function update($id, $data){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TPhotosTronconsErdf');
        $photosTroncons = $repo->findOneBy(array('id'=>$id));
        if(!$photosTroncons){
            return null;
        }
        $this->hydrate($photosTroncons, $data);
        $manager->flush();
        return array('id'=>$photosTroncons->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime un cas
     *  paramètres:
     *      id: l'ID de la biométrie à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TPhotosTronconsErdf');
        $photosTroncons = $repo->findOneBy(array('id'=>$id));
        if($photosTroncons){
            $manager->remove($photosTroncons);
            $manager->flush();
            return true;
        }
        return false;
    }
     /* ------------ PEUPLEMENT ---------------
     *  Peuplement des champs aux objets MortElec
     *  paramètres:
     *      obj: l'objet cible
     *      data: le dictionnaire de données
     *  erreurs:
     *      DataObjectException en cas de données invalides
     */

    private function hydrate($obj, $data){
        $obj->setCheminPhoto($data['cheminPhoto']);
        $obj->setCommentaire($data['commentaire']);
        $obj->setNeutralise($data['neutralise']);
        $obj->setAuteur($data['auteur']);
        $obj->setIdInventaireTronconErdf($data['idInventaireTronconErdf']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
