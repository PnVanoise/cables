<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TEquipementsPoteauxErdfController extends Controller{

    // path: GET /cables/eqpoteaux
    public function listEqAction(){
        /*
         * retourne la liste des equipements poteaux ERDF
         */
        $ss = $this->get('tEquipementsPoteauxErdfService');

        return new JsonResponse($ss->getListEq());
    }

    // path: GET cables/poteauxerdf/eqpoteauxerdf/{id} 
    public function listAction($id){
        /*
         * retourne la liste des equipements poteaux ERDF relatifs à l'ID du poteau affiché en détail
         */
        $ss = $this->get('tEquipementsPoteauxErdfService');

        return new JsonResponse($ss->getList($id));
    }

    // path: GET /cables/eqpoteaux/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'un equipement poteaux ERDF
         */
        $ss = $this->get('tEquipementsPoteauxErdfService');

        return new JsonResponse($ss->getOne($id));
    }

    // path: PUT /cables/eqpoteaux 
    public function createAction(Request $req){ // on récupère la requête  
        // vérification du niveau de l'utilisateur
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){ 
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);
        // récupération des méthodes dans le service 
        try{
            $ss = $this->get('tEquipementsPoteauxErdfService');
            // print_r($data);
            return new JsonResponse($ss->create($data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }

        return new JsonResponse(array('id'=>$eqPoteaux->getId()));
    }

    // path: POST /cables/eqpoteaux/{id} 
    public function updateAction(Request $req, $id=null){
        $user = $this->get('userServ');
        if(!$user->checkLevel(3)){
            throw new AccessDeniedHttpException();
        }
        $data = json_decode($req->getContent(), true);



        try{
            $ss = $this->get('tEquipementsPoteauxErdfService');
            return new JsonResponse($ss->update($id, $data));
        }
        catch(DataObjectException $e){
            return new JsonResponse($e->getErrors(), 400);
        }
    }


    // path; DELETE /cables/eqpoteaux/{id} 
    public function deleteAction($id){
        $user = $this->get('userServ');
        $delete = $user->checkLevel(5);
        if(!$delete){
            throw new AccessDeniedHttpException();
        }

        $cascade = true;
        
        $ss = $this->get('tEquipementsPoteauxErdfService');
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

