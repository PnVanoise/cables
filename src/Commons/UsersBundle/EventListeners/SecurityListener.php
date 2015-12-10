<?php

namespace Commons\UsersBundle\EventListeners;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

use Commons\UsersBundle\Controller\DefaultController;

class SecurityListener{

    public function authTokenCheck(FilterControllerEvent $event){


        // récupération du controleur cible de la requete
        $controller = $event->getController()[0];

        // récupération token cookie
        $token = $event->getRequest()->cookies->get('token');

        // récupération token session
        $sessToken = $event->getRequest()->getSession()->get('token');

        if($event->getRequest()->getMethod() != 'GET'){
            if(!$controller instanceof DefaultController){
                if(!$token || $token != $sessToken){
                    throw new AccessDeniedHttpException('erreur token');
                }
            }
        }

        // vérification du niveau de droit
        //$controller->checkAuthLevel($user, $event->getRequest()->getMethod());

    }

    public function authExceptionResponse(GetResponseForExceptionEvent $event){
        if($event->getException() instanceof AccessDeniedHttpException){
            $event->setResponse( new JsonResponse(array(), 403) );
        }
    }
}
