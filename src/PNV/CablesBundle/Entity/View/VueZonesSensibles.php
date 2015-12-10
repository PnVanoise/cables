<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * VueZonesSensibles
 */
class VueZonesSensibles
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom_zone_sensible;

    /**
     * @var string
     */
    private $niveau_sensibilite;

    /**
     * @var string
     */
    private $nb_poteaux_inventories;

    /**
     * @var string
     */
    private $nb_poteaux_inventories_risque_fort;

    /**
     * @var string
     */
    private $nb_poteaux_inventories_risque_secondaire;

    /**
     * @var string
     */
    private $nb_poteaux_inventories_risque_faible;

    /**
     * @var string
     */
    private $nb_poteaux_equipes;

    /**
     * @var string
     */
    private $nb_poteaux_equipes_risque_fort;

    /**
     * @var string
     */
    private $nb_poteaux_equipes_risque_secondaire;

    /**
     * @var string
     */
    private $nb_poteaux_equipes_risque_faible;

    /**
     * @var string
     */
    private $m_troncons_inventories;

    /**
     * @var string
     */
    private $m_troncons_inventories_risque_fort;

    /**
     * @var string
     */
    private $m_troncons_inventories_risque_secondaire;

    /**
     * @var string
     */
    private $m_troncons_inventories_risque_faible;

    /**
     * @var string
     */
    private $m_troncons_equipes;

    /**
     * @var string
     */
    private $m_troncons_equipes_risque_fort;

    /**
     * @var string
     */
    private $m_troncons_equipes_risque_secondaire;

    /**
     * @var string
     */
    private $m_troncons_equipes_risque_faible;

    /**
     * @var array
     */
    private $geom;


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
     * Set nom_zone_sensible
     *
     * @param string $nomZoneSensible
     * @return VueZonesSensibles
     */
    public function setNomZoneSensible($nomZoneSensible)
    {
        $this->nom_zone_sensible = $nomZoneSensible;

        return $this;
    }

    /**
     * Get nom_zone_sensible
     *
     * @return string 
     */
    public function getNomZoneSensible()
    {
        return $this->nom_zone_sensible;
    }

    /**
     * Set niveau_sensibilite
     *
     * @param string $niveauSensibilite
     * @return VueZonesSensibles
     */
    public function setNiveauSensibilite($niveauSensibilite)
    {
        $this->niveau_sensibilite = $niveauSensibilite;

        return $this;
    }

    /**
     * Get niveau_sensibilite
     *
     * @return string 
     */
    public function getNiveauSensibilite()
    {
        return $this->niveau_sensibilite;
    }

    /**
     * Set nb_poteaux_inventories
     *
     * @param string $nbPoteauxInventories
     * @return VueZonesSensibles
     */
    public function setNbPoteauxInventories($nbPoteauxInventories)
    {
        $this->nb_poteaux_inventories = $nbPoteauxInventories;

        return $this;
    }

    /**
     * Get nb_poteaux_inventories
     *
     * @return string 
     */
    public function getNbPoteauxInventories()
    {
        return $this->nb_poteaux_inventories;
    }

    /**
     * Set nb_poteaux_inventories_risque_fort
     *
     * @param string $nbPoteauxInventoriesRisqueFort
     * @return VueZonesSensibles
     */
    public function setNbPoteauxInventoriesRisqueFort($nbPoteauxInventoriesRisqueFort)
    {
        $this->nb_poteaux_inventories_risque_fort = $nbPoteauxInventoriesRisqueFort;

        return $this;
    }

    /**
     * Get nb_poteaux_inventories_risque_fort
     *
     * @return string 
     */
    public function getNbPoteauxInventoriesRisqueFort()
    {
        return $this->nb_poteaux_inventories_risque_fort;
    }

    /**
     * Set nb_poteaux_inventories_risque_secondaire
     *
     * @param string $nbPoteauxInventoriesRisqueSecondaire
     * @return VueZonesSensibles
     */
    public function setNbPoteauxInventoriesRisqueSecondaire($nbPoteauxInventoriesRisqueSecondaire)
    {
        $this->nb_poteaux_inventories_risque_secondaire = $nbPoteauxInventoriesRisqueSecondaire;

        return $this;
    }

    /**
     * Get nb_poteaux_inventories_risque_secondaire
     *
     * @return string 
     */
    public function getNbPoteauxInventoriesRisqueSecondaire()
    {
        return $this->nb_poteaux_inventories_risque_secondaire;
    }

    /**
     * Set nb_poteaux_inventories_risque_faible
     *
     * @param string $nbPoteauxInventoriesRisqueFaible
     * @return VueZonesSensibles
     */
    public function setNbPoteauxInventoriesRisqueFaible($nbPoteauxInventoriesRisqueFaible)
    {
        $this->nb_poteaux_inventories_risque_faible = $nbPoteauxInventoriesRisqueFaible;

        return $this;
    }

    /**
     * Get nb_poteaux_inventories_risque_faible
     *
     * @return string 
     */
    public function getNbPoteauxInventoriesRisqueFaible()
    {
        return $this->nb_poteaux_inventories_risque_faible;
    }

    /**
     * Set nb_poteaux_equipes
     *
     * @param string $nbPoteauxEquipes
     * @return VueZonesSensibles
     */
    public function setNbPoteauxEquipes($nbPoteauxEquipes)
    {
        $this->nb_poteaux_equipes = $nbPoteauxEquipes;

        return $this;
    }

    /**
     * Get nb_poteaux_equipes
     *
     * @return string 
     */
    public function getNbPoteauxEquipes()
    {
        return $this->nb_poteaux_equipes;
    }

    /**
     * Set nb_poteaux_equipes_risque_fort
     *
     * @param string $nbPoteauxEquipesRisqueFort
     * @return VueZonesSensibles
     */
    public function setNbPoteauxEquipesRisqueFort($nbPoteauxEquipesRisqueFort)
    {
        $this->nb_poteaux_equipes_risque_fort = $nbPoteauxEquipesRisqueFort;

        return $this;
    }

    /**
     * Get nb_poteaux_equipes_risque_fort
     *
     * @return string 
     */
    public function getNbPoteauxEquipesRisqueFort()
    {
        return $this->nb_poteaux_equipes_risque_fort;
    }

    /**
     * Set nb_poteaux_equipes_risque_secondaire
     *
     * @param string $nbPoteauxEquipesRisqueSecondaire
     * @return VueZonesSensibles
     */
    public function setNbPoteauxEquipesRisqueSecondaire($nbPoteauxEquipesRisqueSecondaire)
    {
        $this->nb_poteaux_equipes_risque_secondaire = $nbPoteauxEquipesRisqueSecondaire;

        return $this;
    }

    /**
     * Get nb_poteaux_equipes_risque_secondaire
     *
     * @return string 
     */
    public function getNbPoteauxEquipesRisqueSecondaire()
    {
        return $this->nb_poteaux_equipes_risque_secondaire;
    }

    /**
     * Set nb_poteaux_equipes_risque_faible
     *
     * @param string $nbPoteauxEquipesRisqueFaible
     * @return VueZonesSensibles
     */
    public function setNbPoteauxEquipesRisqueFaible($nbPoteauxEquipesRisqueFaible)
    {
        $this->nb_poteaux_equipes_risque_faible = $nbPoteauxEquipesRisqueFaible;

        return $this;
    }

    /**
     * Get nb_poteaux_equipes_risque_faible
     *
     * @return string 
     */
    public function getNbPoteauxEquipesRisqueFaible()
    {
        return $this->nb_poteaux_equipes_risque_faible;
    }

    /**
     * Set m_troncons_inventories
     *
     * @param string $mTronconsInventories
     * @return VueZonesSensibles
     */
    public function setMTronconsInventories($mTronconsInventories)
    {
        $this->m_troncons_inventories = $mTronconsInventories;

        return $this;
    }

    /**
     * Get m_troncons_inventories
     *
     * @return string 
     */
    public function getMTronconsInventories()
    {
        return $this->m_troncons_inventories;
    }

    /**
     * Set m_troncons_inventories_risque_fort
     *
     * @param string $mTronconsInventoriesRisqueFort
     * @return VueZonesSensibles
     */
    public function setMTronconsInventoriesRisqueFort($mTronconsInventoriesRisqueFort)
    {
        $this->m_troncons_inventories_risque_fort = $mTronconsInventoriesRisqueFort;

        return $this;
    }

    /**
     * Get m_troncons_inventories_risque_fort
     *
     * @return string 
     */
    public function getMTronconsInventoriesRisqueFort()
    {
        return $this->m_troncons_inventories_risque_fort;
    }

    /**
     * Set m_troncons_inventories_risque_secondaire
     *
     * @param string $mTronconsInventoriesRisqueSecondaire
     * @return VueZonesSensibles
     */
    public function setMTronconsInventoriesRisqueSecondaire($mTronconsInventoriesRisqueSecondaire)
    {
        $this->m_troncons_inventories_risque_secondaire = $mTronconsInventoriesRisqueSecondaire;

        return $this;
    }

    /**
     * Get m_troncons_inventories_risque_secondaire
     *
     * @return string 
     */
    public function getMTronconsInventoriesRisqueSecondaire()
    {
        return $this->m_troncons_inventories_risque_secondaire;
    }

    /**
     * Set m_troncons_inventories_risque_faible
     *
     * @param string $mTronconsInventoriesRisqueFaible
     * @return VueZonesSensibles
     */
    public function setMTronconsInventoriesRisqueFaible($mTronconsInventoriesRisqueFaible)
    {
        $this->m_troncons_inventories_risque_faible = $mTronconsInventoriesRisqueFaible;

        return $this;
    }

    /**
     * Get m_troncons_inventories_risque_faible
     *
     * @return string 
     */
    public function getMTronconsInventoriesRisqueFaible()
    {
        return $this->m_troncons_inventories_risque_faible;
    }

    /**
     * Set m_troncons_equipes
     *
     * @param string $mTronconsEquipes
     * @return VueZonesSensibles
     */
    public function setMTronconsEquipes($mTronconsEquipes)
    {
        $this->m_troncons_equipes = $mTronconsEquipes;

        return $this;
    }

    /**
     * Get m_troncons_equipes
     *
     * @return string 
     */
    public function getMTronconsEquipes()
    {
        return $this->m_troncons_equipes;
    }

    /**
     * Set m_troncons_equipes_risque_fort
     *
     * @param string $mTronconsEquipesRisqueFort
     * @return VueZonesSensibles
     */
    public function setMTronconsEquipesRisqueFort($mTronconsEquipesRisqueFort)
    {
        $this->m_troncons_equipes_risque_fort = $mTronconsEquipesRisqueFort;

        return $this;
    }

    /**
     * Get m_troncons_equipes_risque_fort
     *
     * @return string 
     */
    public function getMTronconsEquipesRisqueFort()
    {
        return $this->m_troncons_equipes_risque_fort;
    }

    /**
     * Set m_troncons_equipes_risque_secondaire
     *
     * @param string $mTronconsEquipesRisqueSecondaire
     * @return VueZonesSensibles
     */
    public function setMTronconsEquipesRisqueSecondaire($mTronconsEquipesRisqueSecondaire)
    {
        $this->m_troncons_equipes_risque_secondaire = $mTronconsEquipesRisqueSecondaire;

        return $this;
    }

    /**
     * Get m_troncons_equipes_risque_secondaire
     *
     * @return string 
     */
    public function getMTronconsEquipesRisqueSecondaire()
    {
        return $this->m_troncons_equipes_risque_secondaire;
    }

    /**
     * Set m_troncons_equipes_risque_faible
     *
     * @param string $mTronconsEquipesRisqueFaible
     * @return VueZonesSensibles
     */
    public function setMTronconsEquipesRisqueFaible($mTronconsEquipesRisqueFaible)
    {
        $this->m_troncons_equipes_risque_faible = $mTronconsEquipesRisqueFaible;

        return $this;
    }

    /**
     * Get m_troncons_equipes_risque_faible
     *
     * @return string 
     */
    public function getMTronconsEquipesRisqueFaible()
    {
        return $this->m_troncons_equipes_risque_faible;
    }

    /**
     * Set geom
     *
     * @param array $geom
     * @return VueZonesSensibles
     */
    public function setGeom($geom)
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * Get geom
     *
     * @return array 
     */
    public function getGeom()
    {
        return $this->geom;
    }
}
