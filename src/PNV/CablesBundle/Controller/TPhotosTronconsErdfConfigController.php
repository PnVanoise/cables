<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TPhotosTronconsErdfConfigController extends Controller{ 

    // path : GET cables/config/photostronconserdf/form
    public function getFormAction(){
        $norm = $this->get('normalizer');

        // Définition de le liste de sélection #TInventairePoteauxErdf
        $repo = $this->getDoctrine()->getRepository('PNVCablesBundle:View\TPhotosTronconsErdfView');
        $dico1 = $repo->findAll(array());
        $photosTron = array();
        foreach($dico1 as $d1){
                $photosTron[] = $norm->normalize($d1, array('inventaireTronconErdf'));
        }
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TPhotosTronconsErdf/form.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET cables/config/photostronconserdf/list
    public function getListAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TPhotosTronconsErdf/list.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET cables/config/photostronconserdf/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TPhotosTronconsErdf/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}