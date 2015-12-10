<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEquipementsPoteauxErdfView
 */
class TEquipementsPoteauxErdfView
{
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
     * @var \PNV\CablesBundle\Entity\Dico\DicoNbEquipements
     */
    private $nb_equipements;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoTypeEquipementPoteau
     */
    private $type_equipement_poteau;

    /**
     * @var \PNV\CablesBundle\Entity\View\TInventairePoteauxErdfView
     */
    private $inventaire_poteau_erdf;

    /**
     * @var string
     */
    private $id_nb_equipements;

    /**
     * @var string
     */
    private $id_type_equipement_poteau;

    /**
     * @var string
     */
    private $id_inventaire_poteau_erdf;



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
     * @return TEquipementsPoteauxErdfView
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
     * @return TEquipementsPoteauxErdfView
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
     * @return TEquipementsPoteauxErdfView
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
     * @param \PNV\CablesBundle\Entity\Dico\DicoNbEquipements $nbEquipements
     * @return TEquipementsPoteauxErdfView
     */
    public function setNbEquipements(\PNV\CablesBundle\Entity\Dico\DicoNbEquipements $nbEquipements = null)
    {
        $this->nb_equipements = $nbEquipements;

        return $this;
    }

    /**
     * Get nb_equipements
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoNbEquipements 
     */
    public function getNbEquipements()
    {
        return $this->nb_equipements;
    }

    /**
     * Set type_equipement_poteau
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoTypeEquipementPoteau $typeEquipementPoteau
     * @return TEquipementsPoteauxErdfView
     */
    public function setTypeEquipementPoteau(\PNV\CablesBundle\Entity\Dico\DicoTypeEquipementPoteau $typeEquipementPoteau = null)
    {
        $this->type_equipement_poteau = $typeEquipementPoteau;

        return $this;
    }

    /**
     * Get type_equipement_poteau
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoTypeEquipementPoteau 
     */
    public function getTypeEquipementPoteau()
    {
        return $this->type_equipement_poteau;
    }

    /**
     * Set inventaire_poteau_erdf
     *
     * @param \PNV\CablesBundle\Entity\View\TInventairePoteauxErdfView $inventairePoteauErdf
     * @return TEquipementsPoteauxErdfView
     */
    public function setInventairePoteauErdf(\PNV\CablesBundle\Entity\View\TInventairePoteauxErdfView $inventairePoteauErdf = null)
    {
        $this->inventaire_poteau_erdf = $inventairePoteauErdf;

        return $this;
    }

    /**
     * Get inventaire_poteau_erdf
     *
     * @return \PNV\CablesBundle\Entity\View\TInventairePoteauxErdfView 
     */
    public function getInventairePoteauErdf()
    {
        return $this->inventaire_poteau_erdf;
    }
    
    
    /**
     * Set id_nb_equipements
     *
     * @param string $idNbEquipements
     * @return TEquipementsPoteauxErdfView
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
     * Set id_type_equipement_poteau
     *
     * @param string $idTypeEquipementPoteau
     * @return TEquipementsPoteauxErdfView
     */
    public function setIdTypeEquipementPoteau($idTypeEquipementPoteau)
    {
        $this->id_type_equipement_poteau = $idTypeEquipementPoteau;

        return $this;
    }

    /**
     * Get id_type_equipement_poteau
     *
     * @return string 
     */
    public function getIdTypeEquipementPoteau()
    {
        return $this->id_type_equipement_poteau;
    }

    /**
     * Set id_inventaire_poteau_erdf
     *
     * @param string $idInventairePoteauErdf
     * @return TEquipementsPoteauxErdfView
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
}
