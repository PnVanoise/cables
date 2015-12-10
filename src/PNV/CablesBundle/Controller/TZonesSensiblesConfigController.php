<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TZonesSensiblesConfigController extends Controller{ 

    // path : GET cables/config/zonessensibles/list
    public function getListAction(){

        $norm = $this->get('normalizer');

        // Définition de la liste de sélection #Nom Espece
        $repo = $this->getDoctrine()->getRepository('PNVCablesBundle:View\VueZonesSensibles');
        $dico1 = $repo->findAll(array());
        $zs = array();
        foreach($dico1 as $d1){
            $zs[] = $norm->normalize($d1, array('geom'));
        }
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TZonesSensibles/list.yml');
        $out = Yaml::parse($file);
        
        // Initialisation des listes de sélection dans le formulaire de création #Voir list.yml
        foreach($out['fields'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['type'] == 'select' && isset($field['nom_zone_sensible'])){
                    $field['options']['choices'] = $zs;
                    unset($field['nom_zone_sensible']);
                }
            }
        }
        return new JsonResponse($out);
    }

    // path : GET cables/config/zonessensibles/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TZonesSensibles/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}