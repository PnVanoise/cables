<?php

namespace Commons\UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class AuthController extends Controller{

    protected $_auth = array();

    public function checkAuthLevel($userLevel, $path){
        if(!isset($this->_auth[$path])){
            return;
        }
        if($userLevel >= $this->_auth[$path]){
            return;
        }
        else{
            throw new AccessDeniedHttpException();
        }
    }
}
