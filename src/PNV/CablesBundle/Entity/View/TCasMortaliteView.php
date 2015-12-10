<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCasMortaliteView
 */
class TCasMortaliteView
{

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
    private $id_espece;

    /**
     * @var string
     */
    private $id_cause_mortalite;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\TEspeces
     */
    private $espece;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoCauseMortalite
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
     * @return TCasMortaliteView
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
     * @return TCasMortaliteView
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
     * @return TCasMortaliteView
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
     * @return TCasMortaliteView
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
     * @return TCasMortaliteView
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
     * @return TCasMortaliteView
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
     * @return TCasMortaliteView
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
     * Set id_espece
     *
     * @param string $idEspece
     * @return TCasMortaliteView
     */
    public function setIdEspece($idEspece)
    {
        $this->id_espece = $idEspece;

        return $this;
    }

    /**
     * Get id_espece
     *
     * @return string 
     */
    public function getIdEspece()
    {
        return $this->id_espece;
    }

    /**
     * Set id_cause_mortalite
     *
     * @param string $idCauseMortalite
     * @return TCasMortaliteView
     */
    public function setIdCauseMortalite($idCauseMortalite)
    {
        $this->id_cause_mortalite = $idCauseMortalite;

        return $this;
    }

    /**
     * Get id_cause_mortalite
     *
     * @return string 
     */
    public function getIdCauseMortalite()
    {
        return $this->id_cause_mortalite;
    }

    /**
     * Set espece
     *
     * @param \PNV\CablesBundle\Entity\Dico\TEspeces $espece
     * @return TCasMortaliteView
     */
    public function setEspece(\PNV\CablesBundle\Entity\Dico\TEspeces $espece = null)
    {
        $this->espece = $espece;

        return $this;
    }

    /**
     * Get espece
     *
     * @return \PNV\CablesBundle\Entity\Dico\TEspeces 
     */
    public function getEspece()
    {
        return $this->espece;
    }

    /**
     * Set cause_mortalite
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoCauseMortalite $causeMortalite
     * @return TCasMortaliteView
     */
    public function setCauseMortalite(\PNV\CablesBundle\Entity\Dico\DicoCauseMortalite $causeMortalite = null)
    {
        $this->cause_mortalite = $causeMortalite;

        return $this;
    }

    /**
     * Get cause_mortalite
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoCauseMortalite 
     */
    public function getCauseMortalite()
    {
        return $this->cause_mortalite;
    }
}
