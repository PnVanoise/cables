<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEquipementsPoteauxErdf
 */
class TEquipementsPoteauxErdf
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
    private $dateEquipement;

    /**
     * @var string
     */
    private $loginSaisie;

    /**
     * @var boolean
     */
    private $misEnPlace;

    /**
     * @var string
     */
    private $nb_equipements;

    /**
     * @var string
     */
    private $type_equipement_poteau;

    /**
     * @var string
     */
    private $inventaire_poteau_erdf;


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
     * Set dateEquipement
     *
     * @param \DateTime $dateEquipement
     * @return TEquipementsPoteauxErdf
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
     * Set loginSaisie
     *
     * @param string $loginSaisie
     * @return TEquipementsPoteauxErdf
     */
    public function setLoginSaisie($loginSaisie)
    {
        $this->loginSaisie = $loginSaisie;

        return $this;
    }

    /**
     * Get loginSaisie
     *
     * @return string 
     */
    public function getLoginSaisie()
    {
        return $this->loginSaisie;
    }

    /**
     * Set misEnPlace
     *
     * @param boolean $misEnPlace
     * @return TEquipementsPoteauxErdf
     */
    public function setMisEnPlace($misEnPlace)
    {
        $this->misEnPlace = $misEnPlace;

        return $this;
    }

    /**
     * Get misEnPlace
     *
     * @return boolean 
     */
    public function getMisEnPlace()
    {
        return $this->misEnPlace;
    }

    /**
     * Set nb_equipements
     *
     * @param string $nbEquipements
     * @return TEquipementsPoteauxErdf
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
     * Set type_equipement_poteau
     *
     * @param string $typeEquipementPoteau
     * @return TEquipementsPoteauxErdf
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
     * Set inventaire_poteau_erdf
     *
     * @param string $inventairePoteauErdf
     * @return TEquipementsPoteauxErdf
     */
    public function setInventairePoteauErdf($inventairePoteauErdf)
    {
        $this->inventaire_poteau_erdf = $inventairePoteauErdf;

        return $this;
    }

    /**
     * Get inventaire_poteau_erdf
     *
     * @return string 
     */
    public function getInventairePoteauErdf()
    {
        return $this->inventaire_poteau_erdf;
    }
}
