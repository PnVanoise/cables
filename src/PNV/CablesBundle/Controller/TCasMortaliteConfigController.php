<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TCasMortaliteConfigController extends Controller{ 


   // path : GET cables/config/tronconserdf/form
    public function getFormAction(){
        
        // Select liste pour filtre #Nom Espece dans tableau
        $filter = $this->get('filterService');
        $especes = $filter->get_espece();
        
        // Select liste pour filtre #Cause Mortalité dans tableau 
        $filter = $this->get('filterService');
        $causeMort = $filter->get_causeMort();

        // Select liste pour filtre #Age dans tableau 
        $filter = $this->get('filterService');
        $age = $filter->get_age();

        // Select liste pour filtre #Sexe dans tableau
        $filter = $this->get('filterService');
        $sexe = $filter->get_sexe();

        // Select liste pour filtre #Source dans tableau             
        $filter = $this->get('filterService');
        $source = $filter->get_source();
                    
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TCasMortalite/form.yml');
        $out = Yaml::parse($file);

        // Initialisation des listes de sélection dans le formulaire de création #Voir form.yml 
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'id_espece'){
                    $field['options']['choices'] = $especes;
                }
                if($field['name'] == 'id_cause_mortalite'){
                    $field['options']['choices'] = $causeMort;
                }
                if($field['name'] == 'sexe'){
                    $field['options']['choices'] = $sexe;
                }
                if($field['name'] == 'age'){
                    $field['options']['choices'] = $age;
                }
                if($field['name'] == 'source'){
                    $field['options']['choices'] = $source;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET cables/config/mortalites/list
    public function getListAction($nullable=true){
        // Select liste pour filtre #Nom Espece dans tableau
        $filter = $this->get('filterService');
        $especes = $filter->get_espece();
        
        // Select liste pour filtre #Cause Mortalité dans tableau 
        $filter = $this->get('filterService');
        $causeMort = $filter->get_causeMort();

        // Select liste pour filtre #Age dans tableau 
        $filter = $this->get('filterService');
        $age = $filter->get_age();

        // Select liste pour filtre #Sexe dans tableau
        $filter = $this->get('filterService');
        $sexe = $filter->get_sexe();

        // Select liste pour filtre #Source dans tableau             
        $filter = $this->get('filterService');
        $source = $filter->get_source();

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TCasMortalite/list.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'espece'){
                $field['options']['choices'] = $especes;
                $field['default'] = 0;
            }
            if($field['name'] == 'cause_mortalite'){
                $field['options']['choices'] = $causeMort;
                $field['default'] = 0;
            }
            if($field['name'] == 'age'){
                $field['options']['choices'] = $age;
                $field['default'] = 0;
            }
            if($field['name'] == 'sexe'){
                $field['options']['choices'] = $sexe;
                $field['default'] = 0;
            }
            
            if($field['name'] == 'source'){
                $field['options']['choices'] = $source;
                $field['default'] = 0;
            }
        }        
    
        return new JsonResponse($out);
    }

    // path : GET cables/config/mortalites/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TCasMortalite/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}