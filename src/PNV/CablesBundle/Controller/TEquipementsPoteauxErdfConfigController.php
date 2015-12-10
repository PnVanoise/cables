<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TEquipementsPoteauxErdfConfigController extends Controller{ 

    // path : GET cables/config/eqpoteauxerdf/form
    public function getFormAction($nullable=true){
       
        // Select liste pour filtre #Nbre d'équipement
        $filter = $this->get('filterService');
        $nbrEq = $filter->get_nbrEquipPoteaux();

        // Select liste pour filtre #Type d'équipement
        $filter = $this->get('filterService');
        $typEq = $filter->get_typeEquipPoteaux();

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TEquipementsPoteauxErdf/form.yml');
        $out = Yaml::parse($file);

        // Initialisation des listes de sélection dans le formulaire de création #Voir form.yml 
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'id_nb_equipements'){
                    $field['options']['choices'] = $nbrEq;
                }
                if($field['name'] == 'id_type_equipement_poteau'){
                    $field['options']['choices'] = $typEq;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET cables/config/eqpoteauxerdf/list
    public function getListAction($nullable=true){
        // Select liste pour filtre #Nom Espece dans tableau           
        $filter = $this->get('filterService');
        $typEq = $filter->get_typeEquipPoteaux();

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TEquipementsPoteauxErdf/list.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'type_equipement_poteau'){
                $field['options']['choices'] = $typEq;
                $field['default'] = 0;
            }
        }        
    
        return new JsonResponse($out);
    }

    // path : GET cables/config/eqpoteauxerdf/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TEquipementsPoteauxErdf/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}