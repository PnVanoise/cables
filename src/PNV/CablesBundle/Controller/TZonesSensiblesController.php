<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TZonesSensiblesController extends Controller{

    // path: GET /cables/zonessensibles 
    public function listAction(Request $request){
        /*
         * retourne la liste des zones sensibles 
         */
        $ss = $this->get('tZonesSensiblesService');

        $full = $request->query->get('short') !== 'true';
        return new JsonResponse($ss->getList($full));
    }

    // path: GET /cables/mortelec/{id} 
    public function detailAction($id){
        /*
         * retourne le détail d'une zone sensible
         */
        $ss = $this->get('tZonesSensiblesService');

        return new JsonResponse($ss->getOne($id));
    }  
}
