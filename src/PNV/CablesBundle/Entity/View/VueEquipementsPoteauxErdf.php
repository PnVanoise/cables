<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * VueEquipementsPoteaux
 */
class VueEquipementsPoteauxErdf
{
    
   
  
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $id_inventaire_poteau_erdf;

    /**
     * @var string
     */
    private $type_equipement_poteau;

    /**
     * @var \DateTime
     */
    private $dateEquipement;

    /**
     * @var string
     */
    private $misEnPlace;

    /**
     * @var string
     */
    private $id_nb_equipements;

    /**
     * @var array
     */
    private $geom_json;


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
     * Set id_inventaire_poteau_erdf
     *
     * @param string $idInventairePoteauErdf
     * @return VueEquipementsPoteauxErdf
     */
    public function setIdInventairePoteauErdf($idInventairePoteauErdf)
    {
        $this->id_inventaire_poteau_erdf = $idInventairePoteauErdf;

        return $this;
    }

    /**
     * Get id_inventaire_poteau_erdf
     *
     * @return string 
     */
    public function getIdInventairePoteauErdf()
    {
        return $this->id_inventaire_poteau_erdf;
    }

    /**
     * Set type_equipement_poteau
     *
     * @param string $typeEquipementPoteau
     * @return VueEquipementsPoteauxErdf
     */
    public function setTypeEquipementPoteau($typeEquipementPoteau)
    {
        $this->type_equipement_poteau = $typeEquipementPoteau;

        return $this;
    }

    /**
     * Get type_equipement_poteau
     *
     * @return string 
     */
    public function getTypeEquipementPoteau()
    {
        return $this->type_equipement_poteau;
    }

    /**
     * Set dateEquipement
     *
     * @param \DateTime $dateEquipement
     * @return VueEquipementsPoteauxErdf
     */
    public function setDateEquipement($dateEquipement)
    {
        $this->dateEquipement = $dateEquipement;

        return $this;
    }

    /**
     * Get dateEquipement
     *
     * @return \DateTime 
     */
    public function getDateEquipement()
    {
        return $this->dateEquipement;
    }

    /**
     * Set misEnPlace
     *
     * @param string $misEnPlace
     * @return VueEquipementsPoteauxErdf
     */
    public function setMisEnPlace($misEnPlace)
    {
        $this->misEnPlace = $misEnPlace;

        return $this;
    }

    /**
     * Get misEnPlace
     *
     * @return string 
     */
    public function getMisEnPlace()
    {
        return $this->misEnPlace;
    }

    /**
     * Set id_nb_equipements
     *
     * @param string $idNbEquipements
     * @return VueEquipementsPoteauxErdf
     */
    public function setIdNbEquipements($idNbEquipements)
    {
        $this->id_nb_equipements = $idNbEquipements;

        return $this;
    }

    /**
     * Get id_nb_equipements
     *
     * @return string 
     */
    public function getIdNbEquipements()
    {
        return $this->id_nb_equipements;
    }

    /**
     * Set geom_json
     *
     * @param array $geomJson
     * @return VueEquipementsPoteauxErdf
     */
    public function setGeomJson($geomJson)
    {
        $this->geom_json = $geomJson;

        return $this;
    }

    /**
     * Get geom_json
     *
     * @return array 
     */
    public function getGeomJson()
    {
        return $this->geom_json;
    }
}
