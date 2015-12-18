<?php

namespace PNV\CablesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class BreadConfigController extends Controller{
    //path : cables/breadcrumb
    public function breadcrumbAction(Request $req){
        $view = $req->get('view');
        $id = $req->get('id');

        $manager = $this->getDoctrine()->getConnection();

        $out = array();
        switch($view){

//==> 1- Mortalité par électrocussions
            case 'mortalites':
                $req = $manager->prepare('SELECT id_cas_mortalite, t_cas_mortalite.id_espece, t_especes.nom_espece as label FROM cables73.t_cas_mortalite LEFT JOIN cables73.t_especes  ON t_especes.id_espece = t_cas_mortalite.id_espece WHERE id_cas_mortalite=:id_cas_mortalite ORDER BY id_cas_mortalite');
                $req->bindValue('id_cas_mortalite', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out[] = array('id'=>$res['id_cas_mortalite'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/mortalites/'.$id);
                $out[] = array('id_cas_mortalite'=>null, 'label'=>'Cas de mortalites', 'link'=>'#/cables/mortalites');
                // $out[] = array('id_cas_mortalite'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_espece'];
        return new JsonResponse(array_reverse($out));
//==> 2- Inventaires troncons ERDF
            case 'tronconserdf':
                $req = $manager->prepare('SELECT id_inventaire_troncon_erdf as label FROM cables73.t_inventaire_troncons_erdf WHERE id_inventaire_troncon_erdf=:id_inventaire_troncon_erdf');
                $req->bindValue('id_inventaire_troncon_erdf', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out2[] = array('id'=>$res['id_inventaire_troncon_erdf'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/tronconserdf/'.$id);
                $out2[] = array('id_inventaire_troncon_erdf'=>null, 'label'=>'Inventaires tronçons ERDF', 'link'=>'#/cables/tronconserdf');
                // $out2[] = array('id_inventaire_troncon_erdf'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_inventaire_troncon_erdf'];
        return new JsonResponse(array_reverse($out2));
//==> 3- Inventaires poteaux ERDF
            case 'poteauxerdf':
                $req = $manager->prepare('SELECT id_inventaire_poteau_erdf as label FROM cables73.t_inventaire_poteaux_erdf WHERE id_inventaire_poteau_erdf=:id_inventaire_poteau_erdf');
                $req->bindValue('id_inventaire_poteau_erdf', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out3[] = array('id'=>$res['id_inventaire_poteau_erdf'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/poteauxerdf/'.$id);
                $out3[] = array('id_inventaire_poteau_erdf'=>null, 'label'=>'Inventaires poteaux ERDF', 'link'=>'#/cables/poteauxerdf');
                // $out3[] = array('id_inventaire_poteau_erdf'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_inventaire_poteau_erdf'];
        return new JsonResponse(array_reverse($out3));
//==> 4- Equipements poteaux ERDF
            case 'eqpoteauxerdf':
                $req = $manager->prepare('SELECT id_equipement_poteau_erdf, dico_type_equipement_poteau.nom_type_equipement_poteau as label FROM cables73.t_equipements_poteaux_erdf LEFT JOIN cables73.dico_type_equipement_poteau  ON dico_type_equipement_poteau.id_type_equipement_poteau = t_equipements_poteaux_erdf.id_type_equipement_poteau WHERE id_equipement_poteau_erdf=:id_equipement_poteau_erdf ORDER BY id_equipement_poteau_erdf');
                $req->bindValue('id_equipement_poteau_erdf', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out4[] = array('id'=>$res['id_equipement_poteau_erdf'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/eqpoteauxerdf/'.$id);
                $out4[] = array('id_equipement_poteau_erdf'=>null, 'label'=>'Equipements poteaux ERDF', 'link'=>'#/cables/eqpoteauxerdf');
                // $out4[] = array('id_equipement_poteau_erdf'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_equipement_poteau_erdf'];
        return new JsonResponse(array_reverse($out4));
//==> 5- Equipements tronçons ERDF
            case 'eqtronconserdf':
                $req = $manager->prepare('SELECT id_equipement_troncon_erdf, dico_type_equipement_troncon.nom_type_equipement_troncon as label FROM cables73.t_equipements_troncons_erdf LEFT JOIN cables73.dico_type_equipement_troncon  ON dico_type_equipement_troncon.id_type_equipement_troncon = t_equipements_troncons_erdf.id_type_equipement_troncon WHERE id_equipement_troncon_erdf=:id_equipement_troncon_erdf ORDER BY id_equipement_troncon_erdf');
                $req->bindValue('id_equipement_troncon_erdf', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out5[] = array('id'=>$res['id_equipement_troncon_erdf'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/eqtronconserdf/'.$id);
                $out5[] = array('id_equipement_troncon_erdf'=>null, 'label'=>'Equipements tronçons ERDF', 'link'=>'#/cables/eqtronconserdf');
                // $out5[] = array('id_equipement_troncon_erdf'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_equipement_troncon_erdf'];
        return new JsonResponse(array_reverse($out5));
//==> 6- Sites de nidifications
            case 'nidifications':
                $req = $manager->prepare('SELECT id_espece, nom_espece as label FROM cables73.v_sites_nidification_zone_tampon WHERE id_espece=:id_espece');
                $req->bindValue('id_espece', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out6[] = array('id'=>$res['id_espece'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/nidifications/'.$id);
                $out6[] = array('id_espece'=>null, 'label'=>'Sites de nidification', 'link'=>'');
                // $out6[] = array('id_espece'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_espece'];
        return new JsonResponse(array_reverse($out6));
//==> 6- Observations
            case 'observations':
                $req = $manager->prepare('SELECT id_observation, t_especes.nom_espece as label FROM cables73.t_observations LEFT JOIN cables73.t_especes  ON t_especes.id_espece = t_observations.id_espece WHERE id_observation=:id_observation ORDER BY id_observation');
                $req->bindValue('id_observation', $id);
                $req->execute();
                $res = $req->fetchAll();
                $res = $res[0];
                $out6[] = array('id'=>$res['id_observation'], 'label'=>implode('/', array_reverse(explode('-', $res['label']))), 'link'=>'#/cables/observations/'.$id);
                $out6[] = array('id_observation'=>null, 'label'=>'Observations', 'link'=>'');
                // $out6[] = array('id_observation'=>null, 'label'=>'Cables', 'link'=>'#/cables');  
                $id = $res['id_observation'];
        return new JsonResponse(array_reverse($out6));
//==>7- Zones sensibles
            case 'zonessensibles':
                $req = $manager->prepare('SELECT id_zone_sensible, nom_zone_sensible as label FROM cables73.v_zones_sensibles WHERE id_zone_sensible=:id_zone_sensible');
                $req->bindValue('id_zone_sensible', $id);
                $req->execute();
                $res1 = $req->fetchAll();
                $res1 = $res1[0];
                $out1[] = array('id'=>$res1['id_zone_sensible'], 'label'=>$res1['label'], 'link'=>'#/cables/zonessensibles/'.$id);
                $out1[] = array('id_cas_mortalite'=>null, 'label'=>'Zones sensibles', 'link'=>'#/cables/zonessensibles');
                // $out1[] = array('id_zone_sensible'=>null, 'label'=>'Cables', 'link'=>'#/cables');
          		$id = $res['id_zone_sensible'];
        }
        return new JsonResponse(array_reverse($out1));
    }
}
