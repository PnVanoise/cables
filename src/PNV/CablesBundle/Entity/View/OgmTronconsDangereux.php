<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * OgmTronconsDangereux
 */
class OgmTronconsDangereux
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var array
     */
    private $geomJson;


    /**
     * Get idtd
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set geomJson
     *
     * @param array $geomJson
     * @return OgmTronconsDangereux
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
