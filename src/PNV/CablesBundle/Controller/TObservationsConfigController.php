<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TObservationsConfigController extends Controller{ 

    // path : GET cables/config/observations/form
    public function getFormAction(){
        $norm = $this->get('normalizer');

        // Définition de la liste de sélection #Nom Espece
        $repo = $this->getDoctrine()->getRepository('PNVCablesBundle:Dico\TEspeces');
        $dico1 = $repo->findAll(array());
        $especes = array();
        foreach($dico1 as $d1){
            $especes[] = $norm->normalize($d1, array());
        }
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TObservations/form.yml');
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

    // path : GET cables/config/mortalites/list
    public function getListAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TObservations/list.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET cables/config/mortalites/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TObservations/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}