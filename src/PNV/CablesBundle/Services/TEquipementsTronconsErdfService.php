<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TEquipementsTronconsErdf;

class TEquipementsTronconsErdfService{
    
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
    public function getList($idInventaireTronconErdf = null){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TEquipementsTronconsErdfView');
        $infos = $repo->findBy(array('id_inventaire_troncon_erdf'=>$idInventaireTronconErdf));
        $out = array();

        // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
            $out_item = $this->norm->normalize($info, array('dateEquipementTroncon', 'geom', 'geomJson', 'inventaireTronconErdf','typeEquipementTroncon'));
            $out_item['cat'] = 'eqtronconserdf';
            $out_item['dateEquipementTroncon'] = !is_null($info->getDateEquipementTroncon()) ? $info->getDateEquipementTroncon()->format('Y-m-d'): '';
            $out_item['inventaire_troncon_erdf']= !is_null($info->getInventaireTronconErdf())? $info->getInventaireTronconErdf()->getId():'';
            $out_item['type_equipement_troncon']= !is_null($info->getTypeEquipementTroncon())? $info->getTypeEquipementTroncon()->getLibelle():'';
            $out_item['geom'] = array($info->getGeomJson()['coordinates']);
            $out[] = $out_item;
        }

        return $out;
    }
    
    public function getListTr(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TEquipementsTronconsErdfView');
        $infos = $repo->findAll();
        $out = array();

        // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'eqtronconserdf',
                    'id'=>$info->getId(),
                    'dateEquipementTroncon'=>!is_null($info->getDateEquipementTroncon()) ? $info->getDateEquipementTroncon()->format('Y-m-d'): '',
                    'loginSaisie'=>$info->getLoginSaisie(),
                    'inventaire_troncon_erdf'=>!is_null($info->getInventaireTronconErdf())? $info->getInventaireTronconErdf()->getId(): 'null', 
                    'type_equipement_troncon'=>!is_null($info->getTypeEquipementTroncon())? $info->getTypeEquipementTroncon()->getLibelle(): 'null', 
                );
                $out_item['geometry'] = $info->getGeomJson();
                $out_item['properties']['geomLabel'] = sprintf('<a href="#/cables/eqtronconserdf/%s">%s</a>',
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TEquipementsTronconsErdfView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }
        $out_item = $this->norm->normalize($info, array('geomJson','geom', 'dateEquipementTroncon', 'inventaireTronconErdf', 'typeEquipementTroncon'));
        $out_item['loginSaisie']= $info->getLoginSaisie();
        $out_item['id_inventaire_troncon_erdf']= $info->getIdInventaireTronconErdf();
        $out_item['id_type_equipement_troncon']= $info->getIdTypeEquipementTroncon();
        $out_item['dateEquipementTroncon'] = !is_null($info->getDateEquipementTroncon()) ? $info->getDateEquipementTroncon()->format('Y-m-d'): '';
        $out_item['inventaire_troncon_erdf']= !is_null($info->getInventaireTronconErdf())? $info->getInventaireTronconErdf()->getId():'';
        $out_item['type_equipement_troncon']= !is_null($info->getTypeEquipementTroncon())? $info->getTypeEquipementTroncon()->getLibelle():'';
        $out_item['geom'] = array($info->getGeomJson()['coordinates']);

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

        $eqTroncons = new TEquipementsTronconsErdf();
    
        try{
            $this->hydrate($eqTroncons, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }

        $manager->persist($eqTroncons); 
        $manager->flush(); 
        $manager->getConnection()->commit();
        return array('id'=>$eqTroncons->getId());

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
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TEquipementsTronconsErdf');
        $eqTroncons = $repo->findOneBy(array('id'=>$id));
        if(!$eqTroncons){
            return null;
        }
        $this->hydrate($eqTroncons, $data);
        $manager->flush();
        return array('id'=>$eqTroncons->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime un cas
     *  paramètres:
     *      id: l'ID de la biométrie à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TEquipementsTronconsErdf');
        $eqTroncons = $repo->findOneBy(array('id'=>$id));
        if($eqTroncons){
            $manager->remove($eqTroncons);
            $manager->flush();
            return true;
        }
        return false;
    } 
     /* ------------ PEUPLEMENT ---------------
     *  Peuplement des champs aux objets 
     *  paramètres:
     *      obj: l'objet cible
     *      data: le dictionnaire de données
     *  erreurs:
     *      DataObjectException en cas de données invalides
     */
    private function hydrate($obj, $data){
        $geom = $this->geometryService->getLineString($data['geom']);
        $obj->setLoginSaisie($data['loginSaisie']);
        $obj->setInventaireTronconErdf($data['idInventaireTronconErdf']);
        $obj->setTypeEquipementTroncon($data['id_type_equipement_troncon']);
        $obj->setGeom($geom);
        $obj->setDateEquipementTroncon(new \DateTime()); 
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
