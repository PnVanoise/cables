<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use PNV\CablesBundle\Entity\Edit\TPhotosPoteauxErdf;

class TPhotosPoteauxErdfController extends Controller{

    // path: GET /cables/photospoteauxerdf 
    public function listPhotosAction(){
        /*
         * retourne la liste des photos poteaux
         */
        $ss = $this->get('tPhotosPoteauxErdfService');

        return new JsonResponse($ss->getListPhotos());
    }
    // path: GET /cables/photospoteauxerdf/{$id} 
    public function listAction($id){
        /*
         * retourne la liste des photos poteaux correspondant à l'ID du poteau affiché en détail
         */
        $ss = $this->get('tPhotosPoteauxErdfService');

        return new JsonResponse($ss->getList($id));
    }

    // path: GET /cables/photospoteauxerdf/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'une  photo poteau
         */
        $ss = $this->get('tPhotosPoteauxErdfService');

        return new JsonResponse($ss->getOne($id));
    }

    // path: PUT /cables/photospoteauxerdf 
    public function createAction(Request $req){ // on récupère la requête  
        // vérification du niveau de l'utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){ 
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        // récupération des méthodes dans le service 
        try{
            $ss = $this->get('tPhotosPoteauxErdfService');
            // print_r($data);
            return new JsonResponse($ss->create($data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }

        return new JsonResponse(array('id'=>$photosPoteaux->getId()));
    }

    // path: POST /cables/photospoteauxerdf/{id} 
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        try{
            $ss = $this->get('tPhotosPoteauxErdfService');
            return new JsonResponse($ss->update($id, $data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }


    // path; DELETE /cables/photospoteauxerdf/{id} 
    public function deleteAction($id){
        $user = $this->get('userServ');
        $delete = $user->checkLevel(5);
        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        $cascade = true;
        
        $ss = $this->get('tPhotosPoteauxErdfService');
        try{
            $res = $ss->remove($id, $cascade);
        }
        catch(CascadeException $e){
            throw new AccessDeniedHttpException();
        }
        if(!$res){
            return new JsonResponse(array('id'=>$id), 404);
        }
        return new JsonResponse(array('id'=>$id));
    }

    // path: POST /upload_photo
    public function uploadPhotosAction(Request $req) { 
        $manager = $this->getDoctrine()->getManager();
        $upd = $this->container->getParameter('kernel.root_dir') . '/../web/img/photos';
        $target_directory = $req->query->get('target', '');
        $updir = $upd . '/' . $target_directory;

        $manager->getConnection()->beginTransaction();
        foreach($req->files as $file){
            try{
                $fichier = new TPhotosPoteauxErdf();
                $fichier->setCheminPhoto($file->getClientOriginalName());
                $manager->persist($fichier);
                $manager->flush();               
                $fileName = $fichier->getId() . '_' . $fichier->getCheminPhoto();   
                $file->move($updir, $fileName);
                // $manager->getConnection()->commit();
                return new JsonResponse(array(
                    'id'=>$fichier->getId(),
                    'cheminPhoto'=>$fileName,
                ));
            }
            catch(\Exception $e){
                $manager->getConnection()->rollback();
                return new JsonResponse(array('err'=>$e->getMessage()), 400);
            }
        }
        return new JsonResponse(array('err'=>'Pas de photos'), 400);
    }
}

