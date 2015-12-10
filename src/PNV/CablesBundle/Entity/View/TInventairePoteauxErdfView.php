<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TInventairePoteauxErdfView
 */
class TInventairePoteauxErdfView
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
     * @var \PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf
     */
    private $type_poteau_erdf;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf
     */
    private $type_poteau_erdf_secondaire;

    /**
     * @var \PNV\CablesBundle\Entity\View\TZonesSensibles
     */
    private $zone_sensible;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoClassesRisque
     */
    private $attractivite;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoClassesRisque
     */
    private $dangerosite;


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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @return TInventairePoteauxErdfView
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
     * @param \PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf $typePoteauErdf
     * @return TInventairePoteauxErdfView
     */
    public function setTypePoteauErdf(\PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf $typePoteauErdf = null)
    {
        $this->type_poteau_erdf = $typePoteauErdf;

        return $this;
    }

    /**
     * Get type_poteau_erdf
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf 
     */
    public function getTypePoteauErdf()
    {
        return $this->type_poteau_erdf;
    }

    /**
     * Set type_poteau_erdf_secondaire
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf $typePoteauErdfSecondaire
     * @return TInventairePoteauxErdfView
     */
    public function setTypePoteauErdfSecondaire(\PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf $typePoteauErdfSecondaire = null)
    {
        $this->type_poteau_erdf_secondaire = $typePoteauErdfSecondaire;

        return $this;
    }

    /**
     * Get type_poteau_erdf_secondaire
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoTypePoteauErdf 
     */
    public function getTypePoteauErdfSecondaire()
    {
        return $this->type_poteau_erdf_secondaire;
    }

    /**
     * Set zone_sensible
     *
     * @param \PNV\CablesBundle\Entity\View\TZonesSensibles $zoneSensible
     * @return TInventairePoteauxErdfView
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
     * Set attractivite
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoClassesRisque $attractivite
     * @return TInventairePoteauxErdfView
     */
    public function setAttractivite(\PNV\CablesBundle\Entity\Dico\DicoClassesRisque $attractivite = null)
    {
        $this->attractivite = $attractivite;

        return $this;
    }

    /**
     * Get attractivite
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoClassesRisque 
     */
    public function getAttractivite()
    {
        return $this->attractivite;
    }

    /**
     * Set dangerosite
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoClassesRisque $dangerosite
     * @return TInventairePoteauxErdfView
     */
    public function setDangerosite(\PNV\CablesBundle\Entity\Dico\DicoClassesRisque $dangerosite = null)
    {
        $this->dangerosite = $dangerosite;

        return $this;
    }

    /**
     * Get dangerosite
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoClassesRisque 
     */
    public function getDangerosite()
    {
        return $this->dangerosite;
    }
    /**
     * @var string
     */
    private $id_type_poteau_erdf;

    /**
     * @var string
     */
    private $id_type_poteau_erdf_secondaire;

    /**
     * @var string
     */
    private $id_attractivite;

    /**
     * @var string
     */
    private $id_dangerosite;

    /**
     * @var string
     */
    private $id_zone_sensible;


    /**
     * Set id_type_poteau_erdf
     *
     * @param string $idTypePoteauErdf
     * @return TInventairePoteauxErdfView
     */
    public function setIdTypePoteauErdf($idTypePoteauErdf)
    {
        $this->id_type_poteau_erdf = $idTypePoteauErdf;

        return $this;
    }

    /**
     * Get id_type_poteau_erdf
     *
     * @return string 
     */
    public function getIdTypePoteauErdf()
    {
        return $this->id_type_poteau_erdf;
    }

    /**
     * Set id_type_poteau_erdf_secondaire
     *
     * @param string $idTypePoteauErdfSecondaire
     * @return TInventairePoteauxErdfView
     */
    public function setIdTypePoteauErdfSecondaire($idTypePoteauErdfSecondaire)
    {
        $this->id_type_poteau_erdf_secondaire = $idTypePoteauErdfSecondaire;

        return $this;
    }

    /**
     * Get id_type_poteau_erdf_secondaire
     *
     * @return string 
     */
    public function getIdTypePoteauErdfSecondaire()
    {
        return $this->id_type_poteau_erdf_secondaire;
    }

    /**
     * Set id_attractivite
     *
     * @param string $idAttractivite
     * @return TInventairePoteauxErdfView
     */
    public function setIdAttractivite($idAttractivite)
    {
        $this->id_attractivite = $idAttractivite;

        return $this;
    }

    /**
     * Get id_attractivite
     *
     * @return string 
     */
    public function getIdAttractivite()
    {
        return $this->id_attractivite;
    }

    /**
     * Set id_dangerosite
     *
     * @param string $idDangerosite
     * @return TInventairePoteauxErdfView
     */
    public function setIdDangerosite($idDangerosite)
    {
        $this->id_dangerosite = $idDangerosite;

        return $this;
    }

    /**
     * Get id_dangerosite
     *
     * @return string 
     */
    public function getIdDangerosite()
    {
        return $this->id_dangerosite;
    }

    /**
     * Set id_zone_sensible
     *
     * @param string $idZoneSensible
     * @return TInventairePoteauxErdfView
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
    private $nb_equipements;


    /**
     * Set nb_equipements
     *
     * @param string $nbEquipements
     * @return TInventairePoteauxErdfView
     */
    public function setNbEquipements($nbEquipements)
    {
        $this->nb_equipements = $nbEquipements;

        return $this;
    }

    /**
     * Get nb_equipements
     *
     * @return string 
     */
    public function getNbEquipements()
    {
        return $this->nb_equipements;
    }
    /**
     * @var string
     */
    private $nbPhotos;


    /**
     * Set nbPhotos
     *
     * @param string $nbPhotos
     * @return TInventairePoteauxErdfView
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
}
