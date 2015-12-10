<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TEquipementsTronconsErdfController extends Controller{

    // path: GET /cables/eqtronconserdferdf 
    public function listTrAction(){
        /*
         * retourne la liste des equipements tronçons ERDF
         */
        $ss = $this->get('tEquipementsTronconsErdfService');

        return new JsonResponse($ss->getListTr());
    }
    // path: GET /cables/tronconserdf/eqtronconserdf/{id} 
    public function listAction($id){
        /*
         * retourne la liste des equipements tronçons ERDF
         */
        $ss = $this->get('tEquipementsTronconsErdfService');

        return new JsonResponse($ss->getList($id));
    }

    // path: GET /cables/eqtronconserdf/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'un equipement tronçons ERDF
         */
        $ss = $this->get('tEquipementsTronconsErdfService');

        return new JsonResponse($ss->getOne($id));
    }

    // path: PUT /cables/eqtronconserdf 
    public function createAction(Request $req){ // on récupère la requête  
        // vérification du niveau de l'utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){ 
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        // récupération des méthodes dans le service 
        try{
            $ss = $this->get('tEquipementsTronconsErdfService');
            // print_r($data);
            return new JsonResponse($ss->create($data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }

        return new JsonResponse(array('id'=>$eqtronconserdf->getId()));
    }

    // path: POST /cables/eqtronconserdf/{id} 
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);

        try{
            $ss = $this->get('tEquipementsTronconsErdfService');
            return new JsonResponse($ss->update($id, $data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }


    // path; DELETE /cables/eqtronconserdf/{id} 
    public function deleteAction($id){
        $user = $this->get('userServ');
        $delete = $user->checkLevel(5);
        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        $cascade = true;
        
        $ss = $this->get('tEquipementsTronconsErdfService');
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

