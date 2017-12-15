<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\TZonesSensibles;


class TZonesSensiblesService{
    
    // doctrine
    private $db;

    // normalizer
    private $normalizer;

    // geometrie service ** Utils **
    private $geometryService;

    public function __construct($db, $normalizer, $geometryService){
        $this->db = $db;
        $this->norm = $normalizer;
        $this->geometryService = $geometryService;
    }


     /* ------------ VUE LISTE ---------------
     * Retourne la liste des zones sensibles
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    public function getList($full){
        $repo = $this->db->getRepository('PNVCablesBundle:View\VueZonesSensibles');
        $infos = $repo->findAll();
        $out = array();

        // definition de la structure de données sous form GeoJson
        foreach($infos as $info){
            $out_item = array('type'=>'Feature');
            $out_item['properties'] = array(
                'cat'=>'zonessensibles',
                'id'=>$info->getId(),
                'nom_zone_sensible'=>$info->getNomZoneSensible(),
                'niveau_sensibilite'=>$info->getNiveauSensibilite(),
                'nb_poteaux_inventories'=>$info->getNbPoteauxInventories(),
                'nb_poteaux_equipes'=>$info->getNbPoteauxEquipes(),
                'm_troncons_inventories'=>$info->getMTronconsInventories(),
                'm_troncons_equipes'=>$info->getMTronconsEquipes(),
            );
            if ($full) {
                $out_item['properties']['nb_poteaux_inventories_risque_fort']= $info->getNbPoteauxInventoriesRisqueFort();
                $out_item['properties']['nb_poteaux_inventories_risque_secondaire']= $info->getNbPoteauxInventoriesRisqueSecondaire();
                $out_item['properties']['nb_poteaux_inventories_risque_faible']= $info->getNbPoteauxInventoriesRisqueFaible();
                $out_item['properties']['nb_poteaux_equipes_risque_fort']= $info->getNbPoteauxEquipesRisqueFort();
                $out_item['properties']['nb_poteaux_equipes_risque_secondaire']= $info->getNbPoteauxEquipesRisqueSecondaire();
                $out_item['properties']['nb_poteaux_equipes_risque_faible']= $info->getNbPoteauxEquipesRisqueFaible();
                $out_item['properties']['m_troncons_inventories_risque_fort']= $info->getMTronconsInventoriesRisqueFort();
                $out_item['properties']['m_troncons_inventories_risque_secondaire']= $info->getMTronconsInventoriesRisqueSecondaire();
                $out_item['properties']['m_troncons_inventories_risque_faible']= $info->getMTronconsInventoriesRisqueFaible();
                $out_item['properties']['m_troncons_equipes_risque_fort']= $info->getMTronconsEquipesRisqueFort();
                $out_item['properties']['m_troncons_equipes_risque_secondaire']= $info->getMTronconsEquipesRisqueSecondaire();
                $out_item['properties']['m_troncons_equipes_risque_faible']= $info->getMTronconsEquipesRisqueFaible();
            }
            $out_item['geometry'] = $info->getGeom();
            $out_item['style'] = array (
                    'color' => '#999',
                    'weight'=> 2,
                    "fillOpacity"=> 0.8,
                    "opacity"=> 1,
                );
            $out_item['properties']['geomLabel'] = sprintf('<a href="#/cables/zonessensibles/%s">%s</a>',
                $info->getId(), $info->getNomZoneSensible());
            $out[] = $out_item;
        }
        return $out;
    }
     /* ------------ VUE UNIQUE ---------------
     *  Retourne le cas sélectionné selon l'id fourni
     *  paramètre: 
     *      id: l'id du cas
     *      findOneById: liste un cas selon son id
     */
    public function getOne($id){
        $repo = $this->db->getRepository('PNVCablesBundle:View\VueZonesSensibles');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }
        $out_item = $this->norm->normalize($info, array('geom'));
        $out_item['nom_zone_sensible']= $info->getNomZoneSensible();
        $out_item['niveau_sensibilite']= $info->getNiveauSensibilite();
        $out_item['nb_poteaux_inventories']= $info->getNbPoteauxInventories();
        $out_item['nb_poteaux_inventories_risque_fort']= $info->getNbPoteauxInventoriesRisqueFort();
        $out_item['nb_poteaux_inventories_risque_secondaire']= $info->getNbPoteauxInventoriesRisqueSecondaire();
        $out_item['nb_poteaux_inventories_risque_faible']= $info->getNbPoteauxInventoriesRisqueFaible();
        $out_item['nb_poteaux_equipes']= $info->getNbPoteauxEquipes();
        $out_item['nb_poteaux_equipes_risque_fort']= $info->getNbPoteauxEquipesRisqueFort();
        $out_item['nb_poteaux_equipes_risque_secondaire']= $info->getNbPoteauxEquipesRisqueSecondaire();
        $out_item['nb_poteaux_equipes_risque_faible']= $info->getNbPoteauxEquipesRisqueFaible();
        $out_item['m_troncons_inventories']= $info->getMTronconsInventories();
        $out_item['m_troncons_inventories_risque_fort']= $info->getMTronconsInventoriesRisqueFort();
        $out_item['m_troncons_inventories_risque_secondaire']= $info->getMTronconsInventoriesRisqueSecondaire();
        $out_item['m_troncons_inventories_risque_faible']= $info->getMTronconsInventoriesRisqueFaible();
        $out_item['m_troncons_equipes']= $info->getMTronconsEquipes();
        $out_item['m_troncons_equipes_risque_fort']= $info->getMTronconsEquipesRisqueFort();
        $out_item['m_troncons_equipes_risque_secondaire']= $info->getMTronconsEquipesRisqueSecondaire();
        $out_item['m_troncons_equipes_risque_faible']= $info->getMTronconsEquipesRisqueFaible();
        $out_item['geom'] = array($info->getGeom()['coordinates']);

        return $out_item;
    }
}
