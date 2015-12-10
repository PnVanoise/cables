<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TInventaireTronconsErdfConfigController extends Controller{ 

    // path : GET cables/config/invtronconserdf/form
    public function getFormAction(){
        $norm = $this->get('normalizer');
        // Définition de la liste de sélection #Risques        
        $filter = $this->get('filterService');
        $risque = $filter->get_risque();       
        
        //Définition de la liste de sélection #Nom zone sensible 
        $filter = $this->get('filterService');
        $zs = $filter->get_zs();
       
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TInventaireTronconsErdf/form.yml');
        $out = Yaml::parse($file);

        // Initialisation des listes de sélection dans le formulaire de création #Voir form.yml 
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'id_risque_integration_bati'){
                    $field['options']['choices'] = $risque;
                }
                if($field['name'] == 'id_risque_deplacement'){
                    $field['options']['choices'] = $risque;
                }
                if($field['name'] == 'id_risque_integration_topo'){
                    $field['options']['choices'] = $risque;
                }
                if($field['name'] == 'id_risque_integration_vegetation'){
                    $field['options']['choices'] = $risque;
                }
                if($field['name'] == 'id_zone_sensible'){
                    $field['options']['choices'] = $zs;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET cables/config/invtronconserdf/list
    public function getListAction(){
        // Définition de la liste de sélection #Risques        
        $filter = $this->get('filterService');
        $risque = $filter->get_risque(); 

        // Select liste pour filtre #Commune
        $filter = $this->get('filterService');
        $commune = $filter->get_commune();

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TInventaireTronconsErdf/list.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'risqueTroncon'){
                $field['options']['choices'] = $risque;
                $field['default'] = 0;
            }
            if($field['name'] == 'risque_integration_bati'){
                $field['options']['choices'] = $risque;
                $field['default'] = 0;
            }
            if($field['name'] == 'risque_deplacement'){
                $field['options']['choices'] = $risque;
                $field['default'] = 0;
            }
            if($field['name'] == 'risque_integration_topo'){
                $field['options']['choices'] = $risque;
                $field['default'] = 0;
            }
            if($field['name'] == 'risque_integration_vegetation'){
                $field['options']['choices'] = $risque;
                $field['default'] = 0;
            }
            if($field['name'] == 'commune'){
                $field['options']['choices'] = $commune;
                $field['default'] = 0;
            }
        }        

        return new JsonResponse($out);
    }

    // path : GET cables/config/invtronconserdf/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TInventaireTronconsErdf/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}