<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\TObservations;
use PNV\CablesBundle\Entity\TEspece;


class TObservationsService{
    
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
     * Retourne la liste de toutes les observations
     * paramètre:
     *    findAll => liste tous les cas selon leurs ids
     */
    public function getList(){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TObservations');
        $infos = $repo->findAll();
        $out = array();

        // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'observations',
                    'id'=>$info->getId(),
                    'lieu'=>$info->getLieu(),
                    'commentaires'=>$info->getCommentaires(),
                    'precisionLoc'=>$info->getPrecisionLoc(),
                    'source'=>$info->getSource(),
                    'date'=>!is_null($info->getDate()) ? $info->getDate()->format('Y-m-d'): '',
                    'espece'=>$info->getEspece()->getLibelle(),
                    'nombre'=>$info->getNombre(),
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TObservations');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }
        $out_item = $this->norm->normalize($info, array('geom','geomJson', 'date' ,'espece'));
        $out_item['lieu']= $info->getLieu();
        $out_item['commentaires']= $info->getCommentaires();
        $out_item['precisionLoc']= $info->getPrecisionLoc();
        $out_item['source']= $info->getSource();
        $out_item['espece']= $info->getEspece()->getLibelle();
        $out_item['nombre']= $info->getNombre();
        $out_item['date'] = !is_null($info->getDate()) ? $info->getDate()->format('Y-m-d'): '';
        $out_item['geom'] = array($info->getGeomJson()['coordinates']);
        return $out_item;
    }
}
