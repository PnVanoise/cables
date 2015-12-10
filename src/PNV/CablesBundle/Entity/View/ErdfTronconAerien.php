<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErdfTronconAerien
 */
class ErdfTronconAerien
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
     * Get id
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
     * @return ErdfTronconAerien
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
