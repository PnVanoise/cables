<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante la création ::: "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TEquipementsPoteauxErdf;


class TEquipementsPoteauxErdfService{
    
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
     * Retourne la liste de tous les Equipements Poteaux Erdf
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    public function getList($idInventairePoteauErdf=null){
       
        $repo = $this->db->getRepository('PNVCablesBundle:View\TEquipementsPoteauxErdfView');
        $infos = $repo->findBy(array('id_inventaire_poteau_erdf'=>$idInventairePoteauErdf));  
        $out = array();
        
        foreach($infos as $info){
            $out_item = $this->norm->normalize($info, array('dateEquipement', 'geomJson', 'nbEquipements','typeEquipementPoteau','inventairePoteauErdf'));
            $out_item['cat'] = 'eqpoteauxerdf';
            $out_item['dateEquipement'] = !is_null($info->getDateEquipement()) ? $info->getDateEquipement()->format('Y-m-d'): '';
            $out_item['loginSaisie']= $info->getLoginSaisie();
            $out_item['misEnPlace']= $info->getMisEnPlace();
            $out_item['nb_equipements']= !is_null($info->getNbEquipements())? $info->getNbEquipements()->getLibelle():'';
            $out_item['type_equipement_poteau']= !is_null($info->getTypeEquipementPoteau())? $info->getTypeEquipementPoteau()->getLibelle():'';
            $out_item['inventaire_poteau_erdf']= !is_null($info->getInventairePoteauErdf())? $info->getInventairePoteauErdf()->getId():'';
          
            $out[] = $out_item;
        }

        return $out;
    }

    public function getListEq(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\VueEquipementsPoteauxErdf');
        $infos = $repo->findAll();

        $out = array();         
        
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'cat'=>'eqpoteauxerdf',
                'id'=>$info->getId(),
                'type_equipement_poteau'=>$info->getTypeEquipementPoteau(),
                'dateEquipement'=>!is_null($info->getDateEquipement()) ? $info->getDateEquipement()->format('Y-m-d'): '',
                'misEnPlace'=>$info->getMisEnPlace(),
                'id_nb_equipements'=>$info->getIdNbEquipements(),
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out_item['properties']['geomLabel'] = sprintf('<a href="#/cables/eqpoteauxerdf/%s"> Equipement poteau Enedis %s</a>',
                $info->getId(), $info->getId());
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
        $has_geom = false;
        $repo = $this->db->getRepository('PNVCablesBundle:View\TEquipementsPoteauxErdfView');
        $info = $repo->findOneById($id);
        if(!$info){
            $has_geom = true;
            $repo = $this->db->getRepository('PNVCablesBundle:View\VueEquipementsPoteauxErdf');
            $info = $repo->findOneById($id);
            if(!$info){
                return null;
            }
        }
        $out_item = $this->norm->normalize($info, array('geomJson','dateEquipement','nbEquipements','typeEquipementPoteau','inventairePoteauErdf'));
        $out_item['dateEquipement'] = !is_null($info->getDateEquipement()) ? $info->getDateEquipement()->format('Y-m-d'): '';
        // $out_item['loginSaisie']= $info->getLoginSaisie();
        $out_item['misEnPlace']= $info->getMisEnPlace();
        $out_item['id_nb_equipements']= $info->getIdNbEquipements();
        $out_item['id_type_equipement_poteau']= $info->getIdTypeEquipementPoteau();
        $out_item['id_inventaire_poteau_erdf']= $info->getIdInventairePoteauErdf();
        $out_item['nb_equipements']= !is_null($info->getNbEquipements())? $info->getNbEquipements()->getLibelle():'';
        $out_item['type_equipement_poteau']= !is_null($info->getTypeEquipementPoteau())? $info->getTypeEquipementPoteau()->getLibelle():'';
        $out_item['inventaire_poteau_erdf']= !is_null($info->getInventairePoteauErdf())? $info->getInventairePoteauErdf()->getId():'';
          
        if($has_geom){
            $out_item['geom'] = array($info->getGeomJson()['coordinates']);
        }
        return $out_item;
    }
    /* ------------ CREATION ---------------
     *  Crée un nouveau Equipement Poteau Erdf avec les données fournies et retourne son ID
    paramètres:
     *      id: l'ID de Equipement Poteau Erdf à créer
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

        $eqPoteaux = new TEquipementsPoteauxErdf();
    
        try{
            $this->hydrate($eqPoteaux, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }

        $manager->persist($eqPoteaux); // on demande à doctrine gérer l'objet $eqPoteaux (il ne crée pas encore la requête dans la base de données)
        $manager->flush(); // et ici, Doctrine regarde tous les objets qu'il gère et exécute uniquement cette requête préparée à chaque fois
        $manager->getConnection()->commit();
        return array('id'=>$eqPoteaux->getId());

    }
    /* ------------ MISE A JOUR ---------------
     *  Met à jour d'un Equipement Poteau Erdf avec les données fournies et retourne son ID
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
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TEquipementsPoteauxErdf');
        $eqPoteaux = $repo->findOneBy(array('id'=>$id));
        if(!$eqPoteaux){
            return null;
        }
        $this->hydrate($eqPoteaux, $data);
        $manager->flush();
        return array('id'=>$eqPoteaux->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime un Equipement Poteau Erdf
     *  paramètres:
     *      id: l'ID eq  à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TEquipementsPoteauxErdf');
        $eqPoteaux = $repo->findOneBy(array('id'=>$id));
        if($eqPoteaux){
            $manager->remove($eqPoteaux);
            $manager->flush();
            return true;
        }
        return false;
    }
     /* ------------ PEUPLEMENT ---------------
     *  Peuplement des champs aux objets TEquipementsPoteauxErdf
     *  paramètres:
     *      obj: l'objet cible
     *      data: le dictionnaire de données
     *  erreurs:
     *      DataObjectException en cas de données invalides
     */

    private function hydrate($obj, $data){
        // print_r($data); 
        $obj->setLoginSaisie($data['loginSaisie']); # à définir avec nom de l'utilisateur connecté
        $obj->setMisEnPlace($data['misEnPlace']);
        $obj->setNbEquipements($data['id_nb_equipements']);
        $obj->setTypeEquipementPoteau($data['id_type_equipement_poteau']);
        $obj->setInventairePoteauErdf($data['idInventairePoteauErdf']);
        $obj->setDateEquipement(new \DateTime($data['dateEquipement'])); 
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
