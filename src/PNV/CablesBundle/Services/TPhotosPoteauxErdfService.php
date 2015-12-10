<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TPhotosPoteauxErdf;


class TPhotosPoteauxErdfService{
    
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
     * Retourne la liste de tous les cas de mortalités
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    public function getList($idInventairePoteauErdf=null){
       
        $repo = $this->db->getRepository('PNVCablesBundle:View\TPhotosPoteauxErdfView');
        $infos = $repo->findBy(array('id_inventaire_poteau_erdf'=>$idInventairePoteauErdf));  
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = $this->norm->normalize($info, array('inventairePoteauErdf'));
            $out_item['cat'] = 'photospoteauxerdf';
            $out_item['cheminPhoto'] = $info->getCheminPhoto();
            $out_item['commentaire']= $info->getCommentaire();
            $out_item['neutralise']= $info->getNeutralise();
            $out_item['auteur']= $info->getAuteur();
            $out_item['id_inventaire_poteau_erdf']= $info->getIdInventairePoteauErdf();
            $out[] = $out_item;
        }

        return $out;
    }

    public function getListPhotos(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TPhotosPoteauxErdfView');
        $infos = $repo->findAll();
        $out = array();
       // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'photospoteauxerdf',
                    'id'=>$info->getId(),
                    'cheminPhoto'=>$info->getCheminPhoto(),
                    'commentaire'=>$info->getCommentaire(),
                    'neutralise'=>$info->getNeutralise(),
                    'auteur'=>$info->getAuteur(),
                    'inventaire_poteau_erdf'=>!is_null($info->getInventairePoteauErdf())? $info->getInventairePoteauErdf()->getId(): 'null',
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TPhotosPoteauxErdfView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }

        $out_item = $this->norm->normalize($info, array('inventairePoteauErdf'));
        $out_item['cheminPhoto']= $info->getCheminPhoto();
        $out_item['commentaire']= $info->getCommentaire();
        $out_item['neutralise']= $info->getNeutralise();
        $out_item['auteur']= $info->getAuteur();
        $out_item['inventaire_poteau_erdf']= !is_null($info->getInventairePoteauErdf())? $info->getInventairePoteauErdf()->getId():'';
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


        $photosPoteaux = new TPhotosPoteauxErdf();
    
        try{
            $this->hydrate($photosPoteaux, $data);           

        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }

        $manager->persist($photosPoteaux); // on demande à doctrine gérer l'objet $photosPoteaux (il ne crée pas encore la requête dans la base de données)
        $manager->flush(); // et ici, Doctrine regarde tous les objets qu'il gère et exécute uniquement cette requête préparée à chaque fois
        $manager->getConnection()->commit();
        return array('id'=>$photosPoteaux->getId());
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
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TPhotosPoteauxErdf');
        $photosPoteaux = $repo->findOneBy(array('id'=>$id));
        if(!$photosPoteaux){
            return null;
        }
        $this->hydrate($photosPoteaux, $data);
        $manager->flush();
        return array('id'=>$photosPoteaux->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime un cas
     *  paramètres:
     *      id: l'ID de la biométrie à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TPhotosPoteauxErdf');
        $photosPoteaux = $repo->findOneBy(array('id'=>$id));
        if($photosPoteaux){
            $manager->remove($photosPoteaux);
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
        // print_r($data);
        $obj->setCheminPhoto($data['cheminPhoto']);
        $obj->setCommentaire($data['commentaire']);
        $obj->setNeutralise($data['neutralise']);
        $obj->setAuteur($data['auteur']);
        $obj->setIdInventairePoteauErdf($data['idInventairePoteauErdf']);
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
