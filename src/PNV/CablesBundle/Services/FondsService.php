<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

class FondsService{
    
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


     /* ------------ Fonds ERDF ---------------
     * Retourne la liste des fonds ERDF
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    // erdfappareilcoupure
    public function getListAC(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\ErdfAppareilCoupure');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"erdfappareilcoupure"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //erdfconnexionaerienne
    public function getListCA(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\ErdfConnexionAerienne');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"erdfconnexionaerienne"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //erdfparafoudre
    public function getListPF(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\ErdfParafoudre');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"erdfparafoudre"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //erdfposteelectrique
    public function getListPE(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\ErdfPosteElectrique');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"erdfposteelectrique"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //erdfremonteeaerosout
    public function getListRA(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\ErdfRemonteeAerosout');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"erdfremonteeaerosout"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //erdftronconaerien
    public function getListTA(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\ErdfTronconAerien');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"erdftronconaerien"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    /* ------------ Fonds OGM ---------------*/
    //ogmcablesremonteesmecaniques
    public function getListCRM(){
         $repo = $this->db->getRepository('PNVCablesBundle:View\OgmCablesRemonteesMecaniques');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"ogmcablesremonteesmecaniques"
                // 'issdd'=>$info->getTypeinfra(),
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    
    //ogmdomainesskiables
    public function getListDS(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\OgmDomainesSkiables');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"ogmdomainesskiables"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //ogmtronconsdangereux
    public function getListTD(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\OgmTronconsDangereux');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"ogmtronconsdangereux"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //ogmtronconsvisualises
    public function getListTV(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\OgmTronconsVisualises');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"ogmtronconsvisualises"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //ogmtronconsvisualisesdangereux
    public function getListTVD(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\OgmTronconsVisualisesDangereux');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"ogmtronconsvisualisesdangereux"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    /* ------------ Fonds RTE ---------------*/
    //rtelignes
    public function getListLG(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\RteLignes');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"rtelignes"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //rtepostes
    public function getListPO(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\RtePostes');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"rtepostes"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //rtepoteaux
    public function getListPT(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\RtePoteaux');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"rtepoteaux"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    /* ------------ Fonds Autres ---------------*/
    //axesmigratoires
    public function getListAM(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TAxesMigratoires');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
    //communes
    public function getListCO(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TCommunes');
        $infos = $repo->findAll();
        $out = array();
        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'id'=>$info->getId(),
                'cat'=>"communes"
            );
            $out_item['geometry'] = $info->getGeomJson();
            $out[] = $out_item;
        }
        return $out;
    }
}
