<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TSitesNidificationController extends Controller{

    // path: GET /cables/nidification 
    public function listAction(){
        /*
         * retourne la liste des nidifications
         */
        $ss = $this->get('tSitesNidificationService');

        return new JsonResponse($ss->getList());
    }

    // path: GET /cables/nidification/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'un nidification
         */
        $ss = $this->get('tSitesNidificationService');

        return new JsonResponse($ss->getOne($id));
    }

 
}

