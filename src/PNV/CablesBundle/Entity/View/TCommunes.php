<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TCommunes
 */
class TCommunes
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nomCommune;

    /**
     * @var array
     */
    private $geomJson;


    /**
     * Get in
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomCommune
     *
     * @param string $nomCommune
     * @return TCommunes
     */
    public function setNomCommune($nomCommune)
    {
        $this->nomCommune = $nomCommune;

        return $this;
    }

    /**
     * Get nomCommune
     *
     * @return string 
     */
    public function getNomCommune()
    {
        return $this->nomCommune;
    }

    /**
     * Set geomJson
     *
     * @param array $geomJson
     * @return TCommunes
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
}
