<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class AppConfigController extends Controller{
    
    public function indexAction(){
        return new BinaryFileResponse('cables.html');
    }

    //path: GET /config/apps
    public function getAppsAction(){
        // Accès à l'ID de l'appli pour la gestion du contenu spécifique
        $path = $this->container->getParameter('kernel.root_dir').'/config_appli_cables.txt';
        $app = intval(file_get_contents($path, null, null, 0, 3));

        // Méthode de récupération de l'id depuis un fichier texte
        // $path = $this->container->getParameter('kernel.root_dir').'../web/js/resources/config_appli_cables.txt';
        // $app = intval(file_get_contents($path, null, null, 0, 3));
        
        // Méthode de récupération de l'id depuis un json
        $path = $this->container->getParameter('kernel.root_dir').'/../web/js/resources/defaultMap.json';
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        $app_id = $data[0]['id_appli'];
        return new JsonResponse(array(
            array('id'=>'1', 'name'=>'cables', 'appId'=>$app_id),
        ));
    }
	

 //    // path: DELETE /upload_file/{file_id}
 //    public function deleteFileAction(Request $req, $file_id){
 //        $upd = $this->get('kernel')->getContainer()->getParameter('upload_directory');
 //        $target_directory = $req->query->get('target', '');
 //        $updir = $upd . '/' . $target_directory;

 //        $id = substr($file_id, 0, strpos($file_id, '_'));
 //        $deleted = false;
 //        $repo = $this->getDoctrine()->getRepository('PNVCablesBundle\Edit:TPhotosPoteauxErdf');
 //        $fich = $repo->findOneById($id);
 //        $manager = $this->getDoctrine()->getManager();
 //        $manager->remove($fich);
 //        $manager->flush();
 //        $target_directory = $req->request->get('target', '');
 //        $fdir = $updir . '/' . $file_id;
 //        if(file_exists($fdir)){
 //            unlink($fdir);
 //            $deleted = true;
 //        }
 //        return new JsonResponse(array(
 //            'id'=>$file_id, 
 //            'fichier'=>$fich,
 //            'fdir'=>$fdir,
 //            'deleted'=>$deleted
 //        ));
 //    }
}