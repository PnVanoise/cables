<?php

namespace PNV\CablesBundle\Entity\Dico;

use Doctrine\ORM\Mapping as ORM;

/**
 * DicoTypeEquipementTroncon
 */
class DicoTypeEquipementTroncon
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
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
     * @param string $libelle
     * @return DicoTypeEquipementTroncon
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}
