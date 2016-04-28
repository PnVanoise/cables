<?php
namespace PNV\CablesBundle\Services;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Commons\Exceptions\DataObjectException;
use Commons\Exceptions\CascadeException;
// Répertoire où se trouve les données à envoyer pendante "hydrate"
// En déclarer plusieurs si on veut envoyer des données dans plusieurs tables
use PNV\CablesBundle\Entity\Edit\TCasMortalite;
class TCasMortaliteService{
    
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
            $repo = $this->db->getRepository('PNVCablesBundle:View\TCasMortaliteView');
            $infos = $repo->findAll();
            $out = array();
            // definition de la structure de données sous form GeoJson
            foreach($infos as $info){
                $out_item = array('type'=>'Feature');
                $out_item['properties'] = array(
                    'cat'=>'mortalites',                  
                    'id'=>$info->getId(),
                    'source'=>$info->getSource(),
                    'nb_cas'=>$info->getNbCas(),
                    'sexe'=>$info->getSexe(), 
                    'age'=>$info->getAge(),
                    'date'=>!is_null($info->getDate()) ? $info->getDate()->format('Y-m-d'): '',
                    'espece'=>!is_null($info->getEspece())? $info->getEspece()->getLibelle(): 'null',
                    'cause_mortalite'=>!is_null($info->getCauseMortalite())? $info->getCauseMortalite()->getLibelle(): 'null',
                );
                $out_item['geometry'] = $info->getGeomJson();
                $out_item['properties']['geomLabel'] = sprintf('<a href="#/cables/mortalites/%s">%s</a>',
                    $info->getId(), $info->getEspece()->getLibelle());
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
        $repo = $this->db->getRepository('PNVCablesBundle:View\TCasMortaliteView');
        $info = $repo->findOneById($id);
        if(!$info){
            throw new NotFoundHttpException();
        }
        $out_item = $this->norm->normalize($info, array('geomJson', 'geom', 'nom_zone_sensible', 'date', 'espece', 'causeMortalite' ));
        $out_item['source']= $info->getSource();
        $out_item['nb_cas']= $info->getNbCas();
        $out_item['sexe']= $info->getSexe();
        $out_item['age']= $info->getAge();
        $out_item['id_espece']= $info->getIdEspece();
        $out_item['id_cause_mortalite']= $info->getIdCauseMortalite();
        $out_item['date']= !is_null($info->getDate()) ? $info->getDate()->format('Y-m-d'): '';
        $out_item['espece']= !is_null($info->getEspece())? $info->getEspece()->getLibelle():'';
        $out_item['cause_mortalite']= !is_null($info->getCauseMortalite())? $info->getCauseMortalite()->getLibelle():'';
        $out_item['geom'] = array($info->getGeomJson()['coordinates']);
        return $out_item;
    } 
    /* ------------ CREATION ---------------
     *  Créé un nouveau cas de mortalité avec les données fournies et retourne son ID
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
        $mort = new TCasMortalite();
    
        try{
            $this->hydrate($mort, $data);
        }
        catch(DataObjectException $e){
            $errors = array_merge($errors, $e->getErrors());
            $manager->getConnection()->rollback();
        }
        if($errors){
            throw new DataObjectException($errors);
        }
        $manager->persist($mort); // on demande à doctrine gérer l'objet $mort (il ne crée pas encore la requête dans la base de données)
        $manager->flush(); // et ici, Doctrine regarde tous les objets qu'il gère et exécute uniquement cette requête préparée à chaque fois
        $manager->getConnection()->commit();
        return array('id'=>$mort->getId());
    }
    /* ------------ MISE A JOUR ---------------
     *  Met à jour un cas de mortalité avec les données fournies et retourne son ID
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
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TCasMortalite');
        $mort = $repo->findOneBy(array('id'=>$id));
        if(!$mort){
            return null;
        }
        $this->hydrate($mort, $data);
        $manager->flush();
        return array('id'=>$mort->getId());
    }
    /* ------------ SUPPRESSION ---------------
     *  Supprime un cas
     *  paramètres:
     *      id: l'ID de la biométrie à supprimer
     */
    public function remove($id){
        $manager = $this->db->getManager();
        $repo = $this->db->getRepository('PNVCablesBundle:Edit\TCasMortalite');
        $mort = $repo->findOneBy(array('id'=>$id));
        if($mort){
            $manager->remove($mort);
            $manager->flush();
            return true;
        }
        return false;
    }
    /* ------------ PEUPLEMENT ---------------
     *  Peuplement des champs aux objets TCasMortalites
     *  paramètres:
     *      obj: l'objet cible
     *      data: le dictionnaire de données
     *  erreurs:
     *      DataObjectException en cas de données invalides
     */
    private function hydrate($obj, $data){
        $geom = $this->geometryService->getPoint($data['geom']); 
        $date = '2016-04-30'; // test
        $obj->setSource($data['source']); 
        $obj->setNbCas($data['nb_cas']);
        $obj->setSexe($data['sexe']); 
        $obj->setAge($data['age']); 
        $obj->setEspece($data['id_espece']); 
        $obj->setCauseMortalite($data['id_cause_mortalite']); 
        $obj->setGeom($geom);          
        // $obj->setDate(new \DateTime($date)); // test 
        $obj->setDate(new \DateTime($data['date'])); // Nouvelle méthode, à appliquer dans tous les autres services
        // $obj->setDate(new \DateTime());  *** Ce qu'on avait avant *** 
        if($obj->errors()){
            throw new DataObjectException($obj->errors()); 
        }
    }
}