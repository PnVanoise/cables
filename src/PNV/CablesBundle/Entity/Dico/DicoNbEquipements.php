<?php

namespace PNV\CablesBundle\Entity\Dico;

use Doctrine\ORM\Mapping as ORM;

/**
 * DicoNbEquipements
 */
class DicoNbEquipements
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $libelle;


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
     * Set libelle
     *
     * @param integer $libelle
     * @return DicoNbEquipements
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return integer 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}
