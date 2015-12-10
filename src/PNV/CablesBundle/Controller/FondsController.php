<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FondsController extends Controller{

    /*
     * COUCHES ERDF
     */
    // path: GET /cables/erdfappareilcoupure
    public function listACAction(){
        /*
         * retourne la liste des couches erdfappareilcoupure
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListAC());
    }
    // path: GET /cables/erdfconnexionaerienne
    public function listCAAction(){
        /*
         * retourne la liste des couches erdfconnexionaerienne
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListCA());
    }
    // path: GET /cables/erdfparafoudre
    public function listPFAction(){
        /*
         * retourne la liste des couches erdfparafoudre
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListPF());
    } 
    // path: GET /cables/erdfposteelectrique
    public function listPEAction(){
        /*
         * retourne la liste des couches erdfposteelectrique
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListPE());
    }
    // path: GET /cables/erdfremonteeaerosout
    public function listRAAction(){
        /*
         * retourne la liste des couches erdfremonteeaerosout
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListRA());
    }
    // path: GET /cables/erdftronconaerien
    public function listTAAction(){
        /*
         * retourne la liste des couches erdftronconaerien
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListTA());
    }
    /*
     * COUCHES OGM
     */
    // path: GET /cables/ogmcablesremonteesmecaniques
    public function listCRMAction(){
        /*
         * retourne la liste des couches ogmcablesremonteesmecaniques
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListCRM());
    }
    // path: GET /cables/ogmdomainesskiables
    public function listDSAction(){
        /*
         * retourne la liste des couches ogmdomainesskiables
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListDS());
    }
    // path: GET /cables/ogmtronconsdangereux
    public function listTDAction(){
        /*
         * retourne la liste des couches ogmtronconsdangereux
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListTD());
    }
    // path: GET /cables/ogmtronconsvisualises
    public function listTVAction(){
        /*
         * retourne la liste des couches ogmtronconsvisualises
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListTV());
    }
    // path: GET /cables/ogmtronconsvisualisesdangereux
    public function listTVDAction(){
        /*
         * retourne la liste des couches ogmtronconsvisualisesdangereux
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListTVD());
    }
     /*
     * COUCHES RTE
     */
     // path: GET /cables/rtelignes
    public function listLGAction(){
        /*
         * retourne la liste des couches rtelignes
         */
         
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListLG());
    }
    // path: GET /cables/rtepostes
    public function listPOAction(){
        /*
         * retourne la liste des couches rtepostes
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListPO());
    }
    // path: GET /cables/rtepoteaux
    public function listPTAction(){
        /*
         * retourne la liste des couches rtepoteaux
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListPT());
    }
     /*
     * COUCHES Autres
     */
    // path: GET /cables/axesmigratoires
    public function listAMAction(){
        /*
         * retourne la liste des couches axesmigratoires
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListAM());
    }
    // path: GET /cables/communes
    public function listCOAction(){
        /*
         * retourne la liste des couches communes
         */
        $ss = $this->get('fondsService');

        return new JsonResponse($ss->getListCO());
    }
}

