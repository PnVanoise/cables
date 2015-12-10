<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TObservations
 */
class TObservations
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $lieu;

    /**
     * @var string
     */
    private $commentaires;

    /**
     * @var string
     */
    private $precisionLoc;

    /**
     * @var string
     */
    private $source;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var array
     */
    private $geomJson;

    /**
     * @var integer
     */
    private $nombre;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\TEspeces
     */
    private $espece;


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
     * Set lieu
     *
     * @param string $lieu
     * @return TObservations
     */
    public function setLieu($lieu)
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * Get lieu
     *
     * @return string 
     */
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * Set commentaires
     *
     * @param string $commentaires
     * @return TObservations
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    /**
     * Get commentaires
     *
     * @return string 
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * Set precisionLoc
     *
     * @param string $precisionLoc
     * @return TObservations
     */
    public function setPrecisionLoc($precisionLoc)
    {
        $this->precisionLoc = $precisionLoc;

        return $this;
    }

    /**
     * Get precisionLoc
     *
     * @return string 
     */
    public function getPrecisionLoc()
    {
        return $this->precisionLoc;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return TObservations
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
     * Set geom
     *
     * @param geometry $geom
     * @return TObservations
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
     * Set geomJson
     *
     * @param array $geomJson
     * @return TObservations
     */
    public function setGeomJson($geomJson)
    {
        $this->geomJson = $geomJson;

        return $this;
    }

    /**
     * Get geomJson
     *
     * @return array 
     */
    public function getGeomJson()
    {
        return $this->geomJson;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     * @return TObservations
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return integer 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return TObservations
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
     * Set espece
     *
     * @param \PNV\CablesBundle\Entity\Dico\TEspeces $espece
     * @return TObservations
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
}
