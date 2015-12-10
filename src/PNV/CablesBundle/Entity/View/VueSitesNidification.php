<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * VueSitesNidification
 */
class VueSitesNidification
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom_espece;

    /**
     * @var array
     */
    private $geom_json;


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
     * Set nom_espece
     *
     * @param string $nomEspece
     * @return VueSitesNidification
     */
    public function setNomEspece($nomEspece)
    {
        $this->nom_espece = $nomEspece;

        return $this;
    }

    /**
     * Get nom_espece
     *
     * @return string 
     */
    public function getNomEspece()
    {
        return $this->nom_espece;
    }

    /**
     * Set geom_json
     *
     * @param array $geomJson
     * @return VueSitesNidification
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
}
