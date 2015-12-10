<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;

/**
 * TInventaireTronconsErdf
 */
class TInventaireTronconsErdf
{
    private $_errors = array();

    /*
     * Retourne la liste des champs invalides s'il y en a
     * ou false si tout est OK
     */

    public function errors(){
        if(empty($this->_errors)){
            return false;
        }
        return $this->_errors;
    }
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateInventaire;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var string
     */
    private $remarques;

    /**
     * @var boolean
     */
    private $dejaNeutralise;

    /**
     * @var array
     */
    private $geomJson;

    /**
     * @var string
     */
    private $risqueTroncon;

    /**
     * @var string
     */
    private $commune;

    /**
     * @var string
     */
    private $risque_integration_bati;

    /**
     * @var string
     */
    private $risque_deplacement;

    /**
     * @var string
     */
    private $risque_integration_topo;

    /**
     * @var string
     */
    private $risque_integration_vegetation;

    /**
     * @var string
     */
    private $zone_sensible;


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
     * Set dateInventaire
     *
     * @param \DateTime $dateInventaire
     * @return TInventaireTronconsErdf
     */
    public function setDateInventaire($dateInventaire)
    {
        $this->dateInventaire = $dateInventaire;

        return $this;
    }

    /**
     * Get dateInventaire
     *
     * @return \DateTime 
     */
    public function getDateInventaire()
    {
        return $this->dateInventaire;
    }

    /**
     * Set geom
     *
     * @param geometry $geom
     * @return TInventaireTronconsErdf
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
     * Set remarques
     *
     * @param string $remarques
     * @return TInventaireTronconsErdf
     */
    public function setRemarques($remarques)
    {
        $this->remarques = $remarques;

        return $this;
    }

    /**
     * Get remarques
     *
     * @return string 
     */
    public function getRemarques()
    {
        return $this->remarques;
    }

    /**
     * Set dejaNeutralise
     *
     * @param boolean $dejaNeutralise
     * @return TInventaireTronconsErdf
     */
    public function setDejaNeutralise($dejaNeutralise)
    {
        $this->dejaNeutralise = $dejaNeutralise;

        return $this;
    }

    /**
     * Get dejaNeutralise
     *
     * @return boolean 
     */
    public function getDejaNeutralise()
    {
        return $this->dejaNeutralise;
    }

    /**
     * Set geomJson
     *
     * @param array $geomJson
     * @return TInventaireTronconsErdf
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
     * Set risqueTroncon
     *
     * @param string $risqueTroncon
     * @return TInventaireTronconsErdf
     */
    public function setRisqueTroncon($risqueTroncon)
    {
        $this->risqueTroncon = $risqueTroncon;

        return $this;
    }

    /**
     * Get risqueTroncon
     *
     * @return string 
     */
    public function getRisqueTroncon()
    {
        return $this->risqueTroncon;
    }

    /**
     * Set commune
     *
     * @param string $commune
     * @return TInventaireTronconsErdf
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;

        return $this;
    }

    /**
     * Get commune
     *
     * @return string 
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * Set risque_integration_bati
     *
     * @param string $risqueIntegrationBati
     * @return TInventaireTronconsErdf
     */
    public function setRisqueIntegrationBati($risqueIntegrationBati)
    {
        $this->risque_integration_bati = $risqueIntegrationBati;

        return $this;
    }

    /**
     * Get risque_integration_bati
     *
     * @return string 
     */
    public function getRisqueIntegrationBati()
    {
        return $this->risque_integration_bati;
    }

    /**
     * Set risque_deplacement
     *
     * @param string $risqueDeplacement
     * @return TInventaireTronconsErdf
     */
    public function setRisqueDeplacement($risqueDeplacement)
    {
        $this->risque_deplacement = $risqueDeplacement;

        return $this;
    }

    /**
     * Get risque_deplacement
     *
     * @return string 
     */
    public function getRisqueDeplacement()
    {
        return $this->risque_deplacement;
    }

    /**
     * Set risque_integration_topo
     *
     * @param string $risqueIntegrationTopo
     * @return TInventaireTronconsErdf
     */
    public function setRisqueIntegrationTopo($risqueIntegrationTopo)
    {
        $this->risque_integration_topo = $risqueIntegrationTopo;

        return $this;
    }

    /**
     * Get risque_integration_topo
     *
     * @return string 
     */
    public function getRisqueIntegrationTopo()
    {
        return $this->risque_integration_topo;
    }

    /**
     * Set risque_integration_vegetation
     *
     * @param string $risqueIntegrationVegetation
     * @return TInventaireTronconsErdf
     */
    public function setRisqueIntegrationVegetation($risqueIntegrationVegetation)
    {
        $this->risque_integration_vegetation = $risqueIntegrationVegetation;

        return $this;
    }

    /**
     * Get risque_integration_vegetation
     *
     * @return string 
     */
    public function getRisqueIntegrationVegetation()
    {
        return $this->risque_integration_vegetation;
    }

    /**
     * Set zone_sensible
     *
     * @param string $zoneSensible
     * @return TInventaireTronconsErdf
     */
    public function setZoneSensible($zoneSensible)
    {
        $this->zone_sensible = $zoneSensible;

        return $this;
    }

    /**
     * Get zone_sensible
     *
     * @return string 
     */
    public function getZoneSensible()
    {
        return $this->zone_sensible;
    }
}
