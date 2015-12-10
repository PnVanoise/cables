<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\TSitesNidification;
use PNV\CablesBundle\Entity\TEspeces;


class TSitesNidificationService{
    
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
     * Retourne la liste de tous les cas de mortalités
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    public function getList(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\VueSitesNidification');
        $infos = $repo->findAll();
        $out = array();

        // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'nidifications',
                    'id'=>$info->getId(),
                    'nom_espece'=>$info->getNomEspece(),
                );
                $out_item['geometry'] = $info->getGeomJson();
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\VueSitesNidification');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }

        $out_item = $this->norm->normalize($info, array('geomJson'));
        $out_item['nom_espece']= $info->getNomEspece();
        $out_item['geom'] = array($info->getGeomJson()['coordinates']);

        return $out_item;
    }
}
