<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TInventaireTronconsErdfController extends Controller{

    // path: GET /cables/troncons 
    public function listAction(){
        /*
         * retourne la liste des inventaires tronçons erdf
         */
        $ss = $this->get('tInventaireTronconsErdfService');

        return new JsonResponse($ss->getList());
    }

    public function listInZsAction($id){
        /*
         * retourne la liste des inventaires tronçons ERDF relatifs à l'ID de la zone sensible
         */
        $ss = $this->get('tInventaireTronconsErdfService');

        return new JsonResponse($ss->getListinZs($id));
    }

    // path: GET /cables/troncons/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'un inventaire tronçons erdf
         */
        $ss = $this->get('tInventaireTronconsErdfService');

        return new JsonResponse($ss->getOne($id));
    }

    // path: PUT /cables/troncons 
    public function createAction(Request $req){ // on récupère la requête  
        // vérification du niveau de l'utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){ 
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        // récupération des méthodes dans le service 
        try{
            $ss = $this->get('tInventaireTronconsErdfService');
            // print_r($data);
            return new JsonResponse($ss->create($data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }

        return new JsonResponse(array('id'=>$invTroncons->getId()));
    }

    // path: POST /cables/troncons/{id} 
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);



        try{
            $ss = $this->get('tInventaireTronconsErdfService');
            return new JsonResponse($ss->update($id, $data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }


    // path; DELETE /cables/troncons/{id} 
    public function deleteAction($id){
        $user = $this->get('userServ');
        $delete = $user->checkLevel(5);
        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        $cascade = true;
        
        $ss = $this->get('tInventaireTronconsErdfService');
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
  
}

