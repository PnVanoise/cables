<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCasMortalite
 */
class TCasMortalite
{
    private $_errors = array();

    /*
     * Retourne la liste des champs invalides s'il y en a
     * ou false si tout est OK
     */

    public function errors(){
        if(empty($this->_errors)){
            return false;
        }
        return $this->_errors;
    }
   
   


    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $source;

    /**
     * @var integer
     */
    private $nb_cas;

    /**
     * @var string
     */
    private $sexe;

    /**
     * @var string
     */
    private $age;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var array
     */
    private $geom_json;

    /**
     * @var string
     */
    private $espece;

    /**
     * @var string
     */
    private $cause_mortalite;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return TCasMortalite
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set nb_cas
     *
     * @param integer $nbCas
     * @return TCasMortalite
     */
    public function setNbCas($nbCas)
    {
        $this->nb_cas = $nbCas;

        return $this;
    }

    /**
     * Get nb_cas
     *
     * @return integer 
     */
    public function getNbCas()
    {
        return $this->nb_cas;
    }

    /**
     * Set sexe
     *
     * @param string $sexe
     * @return TCasMortalite
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set age
     *
     * @param string $age
     * @return TCasMortalite
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return string 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return TCasMortalite
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set geom
     *
     * @param geometry $geom
     * @return TCasMortalite
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return geometry 
     */
    public function getGeom()
    {
        return $this->geom;
    }

    /**
     * Set geom_json
     *
     * @param array $geomJson
     * @return TCasMortalite
     */
    public function setGeomJson($geomJson)
    {
        $this->geom_json = $geomJson;

        return $this;
    }

    /**
     * Get geom_json
     *
     * @return array 
     */
    public function getGeomJson()
    {
        return $this->geom_json;
    }

    /**
     * Set espece
     *
     * @param string $espece
     * @return TCasMortalite
     */
    public function setEspece($espece)
    {
        $this->espece = $espece;

        return $this;
    }

    /**
     * Get espece
     *
     * @return string 
     */
    public function getEspece()
    {
        return $this->espece;
    }

    /**
     * Set cause_mortalite
     *
     * @param string $causeMortalite
     * @return TCasMortalite
     */
    public function setCauseMortalite($causeMortalite)
    {
        $this->cause_mortalite = $causeMortalite;

        return $this;
    }

    /**
     * Get cause_mortalite
     *
     * @return string 
     */
    public function getCauseMortalite()
    {
        return $this->cause_mortalite;
    }
}
