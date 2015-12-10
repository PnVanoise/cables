<?php

namespace PNV\CablesBundle\Entity\Dico;

use Doctrine\ORM\Mapping as ORM;

/**
 * DicoTypeEquipementPoteau
 */
class DicoTypeEquipementPoteau
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
     * @return DicoTypeEquipementPoteau
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
