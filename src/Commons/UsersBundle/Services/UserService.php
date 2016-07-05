<?php

namespace Commons\UsersBundle\Services;

use Symfony\Component\HttpFoundation\RequestStack;

class UserService{

    protected $requestStack;

    public function __construct(RequestStack $rs){
        $this->requestStack = $rs;
    }

    /*
     * retourne l'utilisateur courant
     */
    public function getUser(){
        $req = $this->requestStack->getCurrentRequest();
        return $req->getSession()->get('user');
    }

    /*
     * vérifie que l'utilisateur a un niveau de droit supérieur
     * ou égal à celui requis
     * params:
     *  le niveau de droits requis (int)
     */
    public function checkLevel($level){
        //FIXME $app par defaut => contournement moche pour ne pas refaire toutes les vues chiro
        $currentUser = $this->getUser();
        //return $currentUser->getMaxDroit() >= $level;

        // Accès à l'ID de l'appli pour la gestion du contenu spécifique
        // $path = '/home/intranetsigdev/projets_angular/cables_cc/app/config_appli_cables.txt';
        // $app_id = intval(file_get_contents($path, null, null, 0, 3));

        // Méthode de récupération de l'id depuis un json
        // Méthode avec container ne fonctionne pas hors des controller
        $path = __DIR__ . '/../../../../web/js/resources/defaultMap.json';
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        $app_id = $data[0]['id_appli'];
        return $currentUser['apps'][$app_id] >= $level;
    }

    /*
     * vérifie que l'utilisateur courant est propriétaire de 
     * l'objet concerné
     * params: 
     *  l'id du propriétaire de l'objet concerné (int)
     */
    public function isOwner($item_owner){
        $currentUser = $this->getUser();
        //return $currentUser->getIdRole() == $item_owner;
        return $currentUser['id_role'] == $item_owner;
    }

}
