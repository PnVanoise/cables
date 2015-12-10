<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TInventaireTronconsErdfView
 */
class TInventaireTronconsErdfView
{
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
     * @var \PNV\CablesBundle\Entity\Dico\DicoClassesRisque
     */
    private $risque_integration_bati;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoClassesRisque
     */
    private $risque_deplacement;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoClassesRisque
     */
    private $risque_integration_topo;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoClassesRisque
     */
    private $risque_integration_vegetation;

    /**
     * @var \PNV\CablesBundle\Entity\View\TZonesSensibles
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
     * @return TInventaireTronconsErdfView
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
     * @return TInventaireTronconsErdfView
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
     * @return TInventaireTronconsErdfView
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
     * @return TInventaireTronconsErdfView
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
     * @return TInventaireTronconsErdfView
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
     * @return TInventaireTronconsErdfView
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
     * @return TInventaireTronconsErdfView
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
     * @param \PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueIntegrationBati
     * @return TInventaireTronconsErdfView
     */
    public function setRisqueIntegrationBati(\PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueIntegrationBati = null)
    {
        $this->risque_integration_bati = $risqueIntegrationBati;

        return $this;
    }

    /**
     * Get risque_integration_bati
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoClassesRisque 
     */
    public function getRisqueIntegrationBati()
    {
        return $this->risque_integration_bati;
    }

    /**
     * Set risque_deplacement
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueDeplacement
     * @return TInventaireTronconsErdfView
     */
    public function setRisqueDeplacement(\PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueDeplacement = null)
    {
        $this->risque_deplacement = $risqueDeplacement;

        return $this;
    }

    /**
     * Get risque_deplacement
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoClassesRisque 
     */
    public function getRisqueDeplacement()
    {
        return $this->risque_deplacement;
    }

    /**
     * Set risque_integration_topo
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueIntegrationTopo
     * @return TInventaireTronconsErdfView
     */
    public function setRisqueIntegrationTopo(\PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueIntegrationTopo = null)
    {
        $this->risque_integration_topo = $risqueIntegrationTopo;

        return $this;
    }

    /**
     * Get risque_integration_topo
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoClassesRisque 
     */
    public function getRisqueIntegrationTopo()
    {
        return $this->risque_integration_topo;
    }

    /**
     * Set risque_integration_vegetation
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueIntegrationVegetation
     * @return TInventaireTronconsErdfView
     */
    public function setRisqueIntegrationVegetation(\PNV\CablesBundle\Entity\Dico\DicoClassesRisque $risqueIntegrationVegetation = null)
    {
        $this->risque_integration_vegetation = $risqueIntegrationVegetation;

        return $this;
    }

    /**
     * Get risque_integration_vegetation
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoClassesRisque 
     */
    public function getRisqueIntegrationVegetation()
    {
        return $this->risque_integration_vegetation;
    }

    /**
     * Set zone_sensible
     *
     * @param \PNV\CablesBundle\Entity\View\TZonesSensibles $zoneSensible
     * @return TInventaireTronconsErdfView
     */
    public function setZoneSensible(\PNV\CablesBundle\Entity\View\TZonesSensibles $zoneSensible = null)
    {
        $this->zone_sensible = $zoneSensible;

        return $this;
    }

    /**
     * Get zone_sensible
     *
     * @return \PNV\CablesBundle\Entity\View\TZonesSensibles 
     */
    public function getZoneSensible()
    {
        return $this->zone_sensible;
    }
    /**
     * @var string
     */
    private $id_risque_integration_bati;

    /**
     * @var string
     */
    private $id_risque_deplacement;

    /**
     * @var string
     */
    private $id_risque_integration_topo;

    /**
     * @var string
     */
    private $id_risque_integration_vegetation;

    /**
     * @var string
     */
    private $id_zone_sensible;


    /**
     * Set id_risque_integration_bati
     *
     * @param string $idRisqueIntegrationBati
     * @return TInventaireTronconsErdfView
     */
    public function setIdRisqueIntegrationBati($idRisqueIntegrationBati)
    {
        $this->id_risque_integration_bati = $idRisqueIntegrationBati;

        return $this;
    }

    /**
     * Get id_risque_integration_bati
     *
     * @return string 
     */
    public function getIdRisqueIntegrationBati()
    {
        return $this->id_risque_integration_bati;
    }

    /**
     * Set id_risque_deplacement
     *
     * @param string $idRisqueDeplacement
     * @return TInventaireTronconsErdfView
     */
    public function setIdRisqueDeplacement($idRisqueDeplacement)
    {
        $this->id_risque_deplacement = $idRisqueDeplacement;

        return $this;
    }

    /**
     * Get id_risque_deplacement
     *
     * @return string 
     */
    public function getIdRisqueDeplacement()
    {
        return $this->id_risque_deplacement;
    }

    /**
     * Set id_risque_integration_topo
     *
     * @param string $idRisqueIntegrationTopo
     * @return TInventaireTronconsErdfView
     */
    public function setIdRisqueIntegrationTopo($idRisqueIntegrationTopo)
    {
        $this->id_risque_integration_topo = $idRisqueIntegrationTopo;

        return $this;
    }

    /**
     * Get id_risque_integration_topo
     *
     * @return string 
     */
    public function getIdRisqueIntegrationTopo()
    {
        return $this->id_risque_integration_topo;
    }

    /**
     * Set id_risque_integration_vegetation
     *
     * @param string $idRisqueIntegrationVegetation
     * @return TInventaireTronconsErdfView
     */
    public function setIdRisqueIntegrationVegetation($idRisqueIntegrationVegetation)
    {
        $this->id_risque_integration_vegetation = $idRisqueIntegrationVegetation;

        return $this;
    }

    /**
     * Get id_risque_integration_vegetation
     *
     * @return string 
     */
    public function getIdRisqueIntegrationVegetation()
    {
        return $this->id_risque_integration_vegetation;
    }

    /**
     * Set id_zone_sensible
     *
     * @param string $idZoneSensible
     * @return TInventaireTronconsErdfView
     */
    public function setIdZoneSensible($idZoneSensible)
    {
        $this->id_zone_sensible = $idZoneSensible;

        return $this;
    }

    /**
     * Get id_zone_sensible
     *
     * @return string 
     */
    public function getIdZoneSensible()
    {
        return $this->id_zone_sensible;
    }
    /**
     * @var string
     */
    private $nbPhotos;

    /**
     * @var string
     */
    private $lgEquipee;

    /**
     * @var string
     */
    private $longueur;


    /**
     * Set nbPhotos
     *
     * @param string $nbPhotos
     * @return TInventaireTronconsErdfView
     */
    public function setNbPhotos($nbPhotos)
    {
        $this->nbPhotos = $nbPhotos;

        return $this;
    }

    /**
     * Get nbPhotos
     *
     * @return string 
     */
    public function getNbPhotos()
    {
        return $this->nbPhotos;
    }

    /**
     * Set lgEquipee
     *
     * @param string $lgEquipee
     * @return TInventaireTronconsErdfView
     */
    public function setLgEquipee($lgEquipee)
    {
        $this->lgEquipee = $lgEquipee;

        return $this;
    }

    /**
     * Get lgEquipee
     *
     * @return string 
     */
    public function getLgEquipee()
    {
        return $this->lgEquipee;
    }

    /**
     * Set longueur
     *
     * @param string $longueur
     * @return TInventaireTronconsErdfView
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;

        return $this;
    }

    /**
     * Get longueur
     *
     * @return string 
     */
    public function getLongueur()
    {
        return $this->longueur;
    }
}
