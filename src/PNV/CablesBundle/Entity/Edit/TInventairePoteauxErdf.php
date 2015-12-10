<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;

/**
 * TInventairePoteauxErdf
 */
class TInventairePoteauxErdf
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
     * @var string
     */
    private $remarques;

    /**
     * @var string
     */
    private $etatPoteau;

    /**
     * @var boolean
     */
    private $neutralisationPrevueIsolation;

    /**
     * @var boolean
     */
    private $neutralisationPrevueDissuasion;

    /**
     * @var boolean
     */
    private $neutralisationPrevueAttraction;

    /**
     * @var boolean
     */
    private $dejaNeutralise;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var array
     */
    private $geomJson;

    /**
     * @var string
     */
    private $risquePoteau;

    /**
     * @var string
     */
    private $commune;

    /**
     * @var string
     */
    private $type_poteau_erdf;

    /**
     * @var string
     */
    private $type_poteau_erdf_secondaire;

    /**
     * @var string
     */
    private $attractivite;

    /**
     * @var string
     */
    private $dangerosite;

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
     * @return TInventairePoteauxErdf
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
     * Set remarques
     *
     * @param string $remarques
     * @return TInventairePoteauxErdf
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
     * Set etatPoteau
     *
     * @param string $etatPoteau
     * @return TInventairePoteauxErdf
     */
    public function setEtatPoteau($etatPoteau)
    {
        $this->etatPoteau = $etatPoteau;

        return $this;
    }

    /**
     * Get etatPoteau
     *
     * @return string 
     */
    public function getEtatPoteau()
    {
        return $this->etatPoteau;
    }

    /**
     * Set neutralisationPrevueIsolation
     *
     * @param boolean $neutralisationPrevueIsolation
     * @return TInventairePoteauxErdf
     */
    public function setNeutralisationPrevueIsolation($neutralisationPrevueIsolation)
    {
        $this->neutralisationPrevueIsolation = $neutralisationPrevueIsolation;

        return $this;
    }

    /**
     * Get neutralisationPrevueIsolation
     *
     * @return boolean 
     */
    public function getNeutralisationPrevueIsolation()
    {
        return $this->neutralisationPrevueIsolation;
    }

    /**
     * Set neutralisationPrevueDissuasion
     *
     * @param boolean $neutralisationPrevueDissuasion
     * @return TInventairePoteauxErdf
     */
    public function setNeutralisationPrevueDissuasion($neutralisationPrevueDissuasion)
    {
        $this->neutralisationPrevueDissuasion = $neutralisationPrevueDissuasion;

        return $this;
    }

    /**
     * Get neutralisationPrevueDissuasion
     *
     * @return boolean 
     */
    public function getNeutralisationPrevueDissuasion()
    {
        return $this->neutralisationPrevueDissuasion;
    }

    /**
     * Set neutralisationPrevueAttraction
     *
     * @param boolean $neutralisationPrevueAttraction
     * @return TInventairePoteauxErdf
     */
    public function setNeutralisationPrevueAttraction($neutralisationPrevueAttraction)
    {
        $this->neutralisationPrevueAttraction = $neutralisationPrevueAttraction;

        return $this;
    }

    /**
     * Get neutralisationPrevueAttraction
     *
     * @return boolean 
     */
    public function getNeutralisationPrevueAttraction()
    {
        return $this->neutralisationPrevueAttraction;
    }

    /**
     * Set dejaNeutralise
     *
     * @param boolean $dejaNeutralise
     * @return TInventairePoteauxErdf
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
     * Set geom
     *
     * @param geometry $geom
     * @return TInventairePoteauxErdf
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
     * Set geomJson
     *
     * @param array $geomJson
     * @return TInventairePoteauxErdf
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
     * Set risquePoteau
     *
     * @param string $risquePoteau
     * @return TInventairePoteauxErdf
     */
    public function setRisquePoteau($risquePoteau)
    {
        $this->risquePoteau = $risquePoteau;

        return $this;
    }

    /**
     * Get risquePoteau
     *
     * @return string 
     */
    public function getRisquePoteau()
    {
        return $this->risquePoteau;
    }

    /**
     * Set commune
     *
     * @param string $commune
     * @return TInventairePoteauxErdf
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
     * Set type_poteau_erdf
     *
     * @param string $typePoteauErdf
     * @return TInventairePoteauxErdf
     */
    public function setTypePoteauErdf($typePoteauErdf)
    {
        $this->type_poteau_erdf = $typePoteauErdf;

        return $this;
    }

    /**
     * Get type_poteau_erdf
     *
     * @return string 
     */
    public function getTypePoteauErdf()
    {
        return $this->type_poteau_erdf;
    }

    /**
     * Set type_poteau_erdf_secondaire
     *
     * @param string $typePoteauErdfSecondaire
     * @return TInventairePoteauxErdf
     */
    public function setTypePoteauErdfSecondaire($typePoteauErdfSecondaire)
    {
        $this->type_poteau_erdf_secondaire = $typePoteauErdfSecondaire;

        return $this;
    }

    /**
     * Get type_poteau_erdf_secondaire
     *
     * @return string 
     */
    public function getTypePoteauErdfSecondaire()
    {
        return $this->type_poteau_erdf_secondaire;
    }

    /**
     * Set attractivite
     *
     * @param string $attractivite
     * @return TInventairePoteauxErdf
     */
    public function setAttractivite($attractivite)
    {
        $this->attractivite = $attractivite;

        return $this;
    }

    /**
     * Get attractivite
     *
     * @return string 
     */
    public function getAttractivite()
    {
        return $this->attractivite;
    }

    /**
     * Set dangerosite
     *
     * @param string $dangerosite
     * @return TInventairePoteauxErdf
     */
    public function setDangerosite($dangerosite)
    {
        $this->dangerosite = $dangerosite;

        return $this;
    }

    /**
     * Get dangerosite
     *
     * @return string 
     */
    public function getDangerosite()
    {
        return $this->dangerosite;
    }

    /**
     * Set zone_sensible
     *
     * @param string $zoneSensible
     * @return TInventairePoteauxErdf
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
