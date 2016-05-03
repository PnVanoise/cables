<?php

namespace PNV\CablesBundle\Services;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;

// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TInventairePoteauxErdf;


class TInventairePoteauxErdfService{
    
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TInventairePoteauxErdfView');
        $infos = $repo->findAll();
        $out = array();

       // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'poteauxerdf',
                    'id'=>$info->getId(),
                    'dejaNeutralise'=>$info->getDejaNeutralise(),
                    'remarques'=>$info->getRemarques(),
                    'etatPoteau'=>$info->getEtatPoteau(),
                    'risquePoteau'=>$info->getRisquePoteau(),
                    'commune'=>$info->getCommune(),
                    'nb_equipement'=> $info->getNbEquipements(),
                    'nbPhotos'=> $info->getNbPhotos(),
                    'neutralisationPrevueIsolation'=>$info->getNeutralisationPrevueIsolation(),
                    'neutralisationPrevueAttraction'=>$info->getNeutralisationPrevueDissuasion(),
                    'dateInventaire'=>!is_null($info->getDateInventaire()) ? $info->getDateInventaire()->format('Y-m-d'): '',
                    'type_poteau_erdf'=>!is_null($info->getTypePoteauErdf())? $info->getTypePoteauErdf()->getLibelle(): 'null',
                    'type_poteau_erdf_secondaire'=>!is_null($info->getTypePoteauErdfSecondaire())? $info->getTypePoteauErdfSecondaire()->getLibelle(): 'null',
                    'zone_sensible'=>!is_null($info->getZoneSensible())? $info->getZoneSensible()->getLibelle(): 'null',
                    'attractivite'=>!is_null($info->getAttractivite())? $info->getAttractivite()->getLibelle(): 'null',
                    'dangerosite'=>!is_null($info->getDangerosite())? $info->getDangerosite()->getLibelle(): 'null',
                );
                $out_item['geometry'] = $info->getGeomJson();
                $out_item['properties']['geomLabel'] = sprintf('<a href="#/cables/poteauxerdf/%s">Poteau ERDF %s</a>',
                    $info->getId(), $info->getId());
                $out[] = $out_item;
            }
            return $out;
    }
    // Inventaires dans détail des zones sensibles s'il y a en 
    public function getListInZS($idZoneSensible=null){
       
        $repo = $this->db->getRepository('PNVCablesBundle:View\TInventairePoteauxErdfView');
        $infos = $repo->findBy(array('id_zone_sensible'=>$idZoneSensible));  
        $out = array();
        
        foreach($infos as $info){
        $out_item = $this->norm->normalize($info, array('geom', 'geomJson','attractivite','dangerosite', 'typePoteauErdf', 'zoneSensible','typePoteauErdfSecondaire', 'dateInventaire'));
        $out_item['cat'] = 'poteauxerdf';          
        $out_item['geom'] = array($info->getGeomjson()['coordinates']);          
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TInventairePoteauxErdfView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }
        $out_item = $this->norm->normalize($info, array('geom','geomJson','attractivite','dangerosite', 'typePoteauErdf', 'zoneSensible','typePoteauErdfSecondaire', 'dateInventaire'));
        $out_item['remarques']= $info->getRemarques();
        $out_item['etatPoteau']= $info->getEtatPoteau();
        $out_item['neutralisationPrevueIsolation']= $info->getNeutralisationPrevueIsolation();
        $out_item['neutralisationPrevueDissuasion']= $info->getNeutralisationPrevueDissuasion();
        $out_item['neutralisationPrevueAttraction']= $info->getNeutralisationPrevueAttraction();
        $out_item['dejaNeutralise']= $info->getDejaNeutralise();
        $out_item['risquePoteau']= $info->getRisquePoteau();
        $out_item['commune']= $info->getCommune();
        $out_item['nb_equipement']= $info->getNbEquipements();
        $out_item['nbPhotos']= $info->getNbPhotos();
        $out_item['id_type_poteau_erdf']= $info->getIdTypePoteauErdf();
        $out_item['id_type_poteau_erdf_secondaire']= $info->getIdTypePoteauErdfSecondaire();
        $out_item['id_zone_sensible']= $info->getIdZoneSensible();
        $out_item['id_attractivite']= $info->getIdAttractivite();
        $out_item['id_dangerosite']= $info->getIdDangerosite();
        $out_item['type_poteau_erdf']= !is_null($info->getTypePoteauErdf())? $info->getTypePoteauErdf()->getLibelle():'';
        $out_item['type_poteau_erdf_secondaire']= !is_null($info->getTypePoteauErdfSecondaire())? $info->getTypePoteauErdfSecondaire()->getLibelle():'';
        $out_item['zone_sensible']= !is_null($info->getZoneSensible())? $info->getZoneSensible()->getLibelle():'';
        $out_item['attractivite']= !is_null($info->getAttractivite())? $info->getAttractivite()->getLibelle():'';
        $out_item['dangerosite']= !is_null($info->getDangerosite())? $info->getDangerosite()->getLibelle():'';
        $out_item['dateInventaire'] = !is_null($info->getDateInventaire()) ? $info->getDateInventaire()->format('Y-m-d'): '';
        $out_item['geom'] = array($info->getGeomjson()['coordinates']);

        return $out_item;
    }
    /* ------------ CREATION ---------------
     *  Crée un nouveau InventairePoteauxErdf avec les données fournies et retourne son ID
    paramètres:
     *      id: l'ID du cas à créer
     *      data: dictionnaire de données
     *  return:
     *      {id: retourne l'id du cas crée}
     *  erreurs:
     *      DataObjectException si les données sont invalides
     */
    public function create($data){
        // print_r($data);
        $manager = $this->db->getManager();
        $manager->getConnection()->beginTransaction();
        $errors = array();

        $invPoteaux = new TInventairePoteauxErdf();
    
        try{
            $this->hydrate($invPoteaux, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }

        $manager->persist($invPoteaux); // on demande à doctrine gérer l'objet $invPoteaux (il ne crée pas encore la requête dans la base de données)
        $manager->flush(); // et ici, Doctrine regarde tous les objets qu'il gère et exécute uniquement cette requête préparée à chaque fois
        $manager->getConnection()->commit();
        return array('id'=>$invPoteaux->getId());
    }
    /* ------------ MISE A JOUR ---------------
     *  Met à jour TInventairePoteauxErdf avec les données fournies et retourne son ID
     *  paramètres:
     *      id: l'ID du cas à modifier
     *      data: dictionnaire de données
     *  return:
     *      {id: retourne l'id du cas modifié}
     *  erreurs:
     *      DataObjectException si les données sont invalides
     */
    public function update($id, $data){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TInventairePoteauxErdf');
        $invPoteaux = $repo->findOneBy(array('id'=>$id));
        if(!$invPoteaux){
            return null;
        }
        $this->hydrate($invPoteaux, $data);
        $manager->flush();
        return array('id'=>$invPoteaux->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime TInventairePoteauxErdf
     *  paramètres:
     *      id: l'ID de la biométrie à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TInventairePoteauxErdf');
        $invPoteaux = $repo->findOneBy(array('id'=>$id));
        if($invPoteaux){
            $manager->remove($invPoteaux);
            $manager->flush();
            return true;
        }
        return false;
    }
     /* ------------ PEUPLEMENT ---------------
     *  Peuplement des champs aux objets MortElec
     *  paramètres:
     *      obj: l'objet cible
     *      data: le dictionnaire de données
     *  erreurs:
     *      DataObjectException en cas de données invalides
     */
    private function hydrate($obj, $data){
        // print_r($data);
        $geom = $this->geometryService->getPoint($data['geom']);
        $obj->setRemarques($data['remarques']);
        $obj->setEtatPoteau($data['etatPoteau']);
        $obj->setNeutralisationPrevueIsolation($data['neutralisationPrevueIsolation']);
        $obj->setNeutralisationPrevueDissuasion($data['neutralisationPrevueDissuasion']);
        $obj->setNeutralisationPrevueAttraction($data['neutralisationPrevueAttraction']);
        $obj->setDejaNeutralise($data['dejaNeutralise']);
        $obj->setRisquePoteau($data['risquePoteau']);
        $obj->setTypePoteauErdf($data['id_type_poteau_erdf']);
        $obj->setTypePoteauErdfSecondaire($data['id_type_poteau_erdf_secondaire']);
        $obj->setZoneSensible($data['id_zone_sensible']);
        $obj->setAttractivite($data['id_attractivite']);
        $obj->setDangerosite($data['id_dangerosite']);
        $obj->setGeom($geom);
        $obj->setDateInventaire(new \DateTime($data['dateInventaire'])); 
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}
