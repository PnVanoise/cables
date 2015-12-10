<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TSitesNidificationConfigController extends Controller{ 

     // path : GET cables/config/nidification/form
    public function getFormAction(){
        $norm = $this->get('normalizer');

        // Définition de le liste de sélection #Dico Poteaux ERDF
        $repo = $this->getDoctrine()->getRepository('PNVCablesBundle:Dico\TEspeces');
        $dico1 = $repo->findAll(array());
        $especes = array();
        foreach($dico1 as $d1){
            
                $especes[] = $norm->normalize($d1, array());
            
        }

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TSitesNidification/form.yml');
        $out = Yaml::parse($file);

        // Initialisation des listes de sélection dans le formulaire de création #Voir form.yml 
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'espece'){
                    $field['options']['choices'] = $especes;
    
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET cables/config/nidification/list
    public function getListAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TSitesNidification/list.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET cables/config/nidification/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TSitesNidification/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}