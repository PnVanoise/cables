<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TInventaireTronconsErdf;


class TInventaireTronconsErdfService{
    
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
    public function getList(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TInventaireTronconsErdfView');
        $infos = $repo->findAll();
        $out = array();

        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'cat'=>'tronconserdf',
                'id'=>$info->getId(),
                'remarques'=>$info->getRemarques(),
                'dejaNeutralise'=>$info->getDejaNeutralise(),
                'risqueTroncon'=>$info->getRisqueTroncon(),
                'commune'=>$info->getCommune(),
                'nbPhotos'=> $info->getNbPhotos(),                
                'lgEquipee'=> $info->getLgEquipee(),                
                'longueur'=> $info->getLongueur(),                
                'dateInventaire'=>!is_null($info->getDateInventaire()) ? $info->getDateInventaire()->format('Y-m-d'): '',
                'risque_integration_bati'=>!is_null($info->getRisqueIntegrationBati())? $info->getRisqueIntegrationBati()->getLibelle(): '',
                'risque_deplacement'=>!is_null($info->getRisqueDeplacement())? $info->getRisqueDeplacement()->getLibelle(): '',
                'risque_integration_topo'=>!is_null($info->getRisqueIntegrationTopo())? $info->getRisqueIntegrationTopo()->getLibelle(): '',
                'risque_integration_vegetation'=>!is_null($info->getRisqueIntegrationVegetation())? $info->getRisqueIntegrationVegetation()->getLibelle(): '',
                'zone_sensible'=>!is_null($info->getZoneSensible())? $info->getZoneSensible()->getLibelle():'',
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out_item['properties']['geomLabel'] = sprintf('<a href="#/cables/tronconserdf/%s">Tronçon ERDF %s</a>',
                $info->getId(), $info->getId());
            $out[] = $out_item;
        }
        return $out;


    }

    // Inventaires dans détail des zones sensibles s'il y a en 
    public function getListInZS($idZoneSensible=null){
       
        $repo = $this->db->getRepository('PNVCablesBundle:View\TInventaireTronconsErdfView');
        $infos = $repo->findBy(array('id_zone_sensible'=>$idZoneSensible));  
        $out = array();
        
        foreach($infos as $info){
        $out_item = $this->norm->normalize($info, array('geom','geomJson','risqueIntegrationBati','risqueDeplacement','risqueIntegrationTopo', 'risqueIntegrationVegetation', 'zoneSensible','typePoteauErdfSecondaire', 'dateInventaire'));
        $out_item['cat'] = 'tronconserdf';    
        $out_item['geom'] = array($info->getGeomjson()['coordinates']);    
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TInventaireTronconsErdfView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }

        $out_item = $this->norm->normalize($info, array('geom','geomJson','risqueIntegrationBati','risqueDeplacement','risqueIntegrationTopo', 'risqueIntegrationVegetation', 'zoneSensible','typePoteauErdfSecondaire', 'dateInventaire'));
        $out_item['remarques']= $info->getRemarques();
        $out_item['risqueTroncon']= $info->getRisqueTroncon();
        $out_item['nbPhotos']= $info->getNbPhotos();
        $out_item['longueur']= $info->getLongueur();
        $out_item['lgEquipe']= $info->getLgEquipee();
        $out_item['id_risque_integration_bati']= $info->getIdRisqueIntegrationBati();
        $out_item['id_risque_deplacement']= $info->getIdRisqueDeplacement();
        $out_item['id_risque_integration_topo']= $info->getIdRisqueIntegrationTopo();
        $out_item['id_risque_integration_vegetation']= $info->getIdRisqueIntegrationVegetation();
        $out_item['id_zone_sensible']= $info->getIdZoneSensible();
        $out_item['risque_integration_bati']= !is_null($info->getRisqueIntegrationBati())? $info->getRisqueIntegrationBati()->getLibelle():'';
        $out_item['zone_sensible']= !is_null($info->getZoneSensible())? $info->getZoneSensible()->getLibelle():'';
        $out_item['risque_deplacement']= !is_null($info->getRisqueDeplacement())? $info->getRisqueDeplacement()->getLibelle():'';
        $out_item['risque_integration_topo']= !is_null($info->getRisqueIntegrationTopo())? $info->getRisqueIntegrationTopo()->getLibelle():'';
        $out_item['risque_integration_vegetation']= !is_null($info->getRisqueIntegrationVegetation())? $info ->getRisqueIntegrationVegetation()->getLibelle():'';
        $out_item['dateInventaire'] = !is_null($info->getDateInventaire()) ? $info->getDateInventaire()->format('Y-m-d'): '';
        $out_item['geom'] = array($info->getGeomjson()['coordinates']);

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

        $invTroncons = new TInventaireTronconsErdf();
    
        try{
            $this->hydrate($invTroncons, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }

        $manager->persist($invTroncons); // on demande à doctrine gérer l'objet $invTroncons (il ne crée pas encore la requête dans la base de données)
        $manager->flush(); // et ici, Doctrine regarde tous les objets qu'il gère et exécute uniquement cette requête préparée à chaque fois
        $manager->getConnection()->commit();
        return array('id'=>$invTroncons->getId());

    }
    /* ------------ MISE A JOUR ---------------
     *  Met à jour d'un cas de mortalité avec les données fournies et retourne son ID
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
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TInventaireTronconsErdf');
        $invTroncons = $repo->findOneBy(array('id'=>$id));
        if(!$invTroncons){
            return null;
        }
        $this->hydrate($invTroncons, $data);
        $manager->flush();
        return array('id'=>$invTroncons->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime un cas
     *  paramètres:
     *      id: l'ID de la biométrie à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TInventaireTronconsErdf');
        $invTroncons = $repo->findOneBy(array('id'=>$id));
        if($invTroncons){
            $manager->remove($invTroncons);
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
        $geom = $this->geometryService->getLineString($data['geom']);
        $obj->setRemarques($data['remarques']);
        $obj->setDejaNeutralise($data['dejaNeutralise']);
        $obj->setRisqueIntegrationBati($data['id_risque_integration_bati']);
        $obj->setRisqueDeplacement($data['id_risque_deplacement']);
        $obj->setRisqueIntegrationTopo($data['id_risque_integration_topo']);
        $obj->setRisqueIntegrationVegetation($data['id_risque_integration_vegetation']);
        $obj->setZoneSensible($data['id_zone_sensible']);
        $obj->setGeom($geom);
        $obj->setDateInventaire(new \DateTime()); 
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
