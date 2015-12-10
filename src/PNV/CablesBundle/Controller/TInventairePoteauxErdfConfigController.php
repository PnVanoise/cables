<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TInventairePoteauxErdfConfigController extends Controller{ 

    // path : GET cables/config/invpoteauxerdf/form
    public function getFormAction(){
        $norm = $this->get('normalizer');
        // Définition de la liste de sélection #DicoTypePoteauErdf
        $filter = $this->get('filterService');
        $typPot = $filter->get_typePoteau();
        
        // Définition de la liste de sélection #DicoTypePoteauErdf secondaire
        $filter = $this->get('filterService');
        $typPot = $filter->get_typePoteau();
       
        // Définition de la liste de sélection #Nom zone sensible 
        $filter = $this->get('filterService');
        $zs = $filter->get_zs();
        
        // Définition de la liste de sélection #attractivite 
        $filter = $this->get('filterService');
        $attr = $filter->get_risque();
        
        // Définition de la liste de sélection #dangerosite
        $filter = $this->get('filterService');
        $dang = $filter->get_risque();
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TInventairePoteauxErdf/form.yml');
        $out = Yaml::parse($file);

        //Initialisation des listes de sélection dans le formulaire de création #Voir form.yml 
        foreach($out['groups'] as &$group){
            foreach($group['fields'] as &$field){
                if(!isset($field['options'])){
                    $field['options'] = array();
                }
                if($field['name'] == 'id_type_poteau_erdf'){
                    $field['options']['choices'] = $typPot;
                }
                if($field['name'] == 'id_type_poteau_erdf_secondaire'){
                    $field['options']['choices'] = $typPot;
                }
                if($field['name'] == 'id_zone_sensible'){
                    $field['options']['choices'] = $zs;
                }
                if($field['name'] == 'id_attractivite'){
                    $field['options']['choices'] = $attr;
                }
                if($field['name'] == 'id_dangerosite'){
                    $field['options']['choices'] = $dang;
                }
            }
        }

        return new JsonResponse($out);
    }

    // path : GET cables/config/invpoteauxerdf/list
    public function getListAction(){
        // Select liste pour filtre #RisquePoteau
        $filter = $this->get('filterService');
        $risquePot = $filter->get_risque();

        // Select liste pour filtre #TypePoteau
        $filter = $this->get('filterService');
        $TypePoteau = $filter->get_typePoteau();

        // Select liste pour filtre #Commune
        $filter = $this->get('filterService');
        $commune = $filter->get_commune();

        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TInventairePoteauxErdf/list.yml');
        $out = Yaml::parse($file);

        foreach($out['fields'] as &$field){
            if(!isset($field['options'])){
                $field['options'] = array();
            }
            if($field['name'] == 'risquePoteau'){
                $field['options']['choices'] = $risquePot;
                $field['default'] = 0;
            }
            if($field['name'] == 'type_poteau_erdf'){
                $field['options']['choices'] = $TypePoteau;
                $field['default'] = 0;
            }
            if($field['name'] == 'type_poteau_erdf_secondaire'){
                $field['options']['choices'] = $TypePoteau;
                $field['default'] = 0;
            }
            if($field['name'] == 'attractivite'){
                $field['options']['choices'] = $risquePot;
                $field['default'] = 0;
            }
            if($field['name'] == 'dangerosite'){
                $field['options']['choices'] = $risquePot;
                $field['default'] = 0;
            }
            if($field['name'] == 'commune'){
                $field['options']['choices'] = $commune;
                $field['default'] = 0;
            }
        }        
    
        return new JsonResponse($out);
    }
    // path : GET cables/config/invpoteauxerdf/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TInventairePoteauxErdf/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}