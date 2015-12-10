<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TZonesSensibles
 */
class TZonesSensibles
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
     * @var integer
     */
    private $niveau_sensibilite;


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
     * @return DicoClassesRisque
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

    /**
     * Set niveau_sensibilite
     *
     * @param integer $niveauSensibilite
     * @return TZonesSensibles
     */
    public function setNiveauSensibilite($niveauSensibilite)
    {
        $this->niveau_sensibilite = $niveauSensibilite;

        return $this;
    }

    /**
     * Get niveau_sensibilite
     *
     * @return integer 
     */
    public function getNiveauSensibilite()
    {
        return $this->niveau_sensibilite;
    }
}
