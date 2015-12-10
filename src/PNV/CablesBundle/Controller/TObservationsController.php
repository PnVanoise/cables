<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TObservationsController extends Controller{

    // path: GET /cables/observations 
    public function listAction(){
        /*
         * retourne la liste des observations
         */
        $ss = $this->get('tObservationsService');

        return new JsonResponse($ss->getList());
    }

    // path: GET /cables/observations/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'une observation
         */
        $ss = $this->get('tObservationsService');

        return new JsonResponse($ss->getOne($id));
    }
  
}

