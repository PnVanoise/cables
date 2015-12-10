<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Yaml\Yaml;

class TPhotosPoteauxErdfConfigController extends Controller{ 

    // path : GET cables/config/photospoteauxerdf/form
    public function getFormAction(){
        $norm = $this->get('normalizer');

        // Définition de le liste de sélection #TInventairePoteauxErdf
        $repo = $this->getDoctrine()->getRepository('PNVCablesBundle:View\TPhotosPoteauxErdfView');
        $dico1 = $repo->findAll(array());
        $photosPot = array();
        foreach($dico1 as $d1){
                $photosPot[] = $norm->normalize($d1, array('inventairePoteauErdf'));
        }
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TPhotosPoteauxErdf/form.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET cables/config/photospoteauxerdf/list
    public function getListAction(){
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TPhotosPoteauxErdf/list.yml');
        $out = Yaml::parse($file);

        return new JsonResponse($out);
    }

    // path : GET cables/config/photospoteauxerdf/detail
    public function getDetailAction(){
        
        $file = file_get_contents(__DIR__ . '/../Resources/clientConf/TPhotosPoteauxErdf/detail.yml');
        $out = Yaml::parse($file);
       
        return new JsonResponse($out);
    }
}