<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEquipementsTronconsErdf
 */
class TEquipementsTronconsErdf
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
    private $dateEquipementTroncon;

    /**
     * @var geometry
     */
    private $geom;

    /**
     * @var string
     */
    private $loginSaisie;

    /**
     * @var array
     */
    private $geomJson;

    /**
     * @var string
     */
    private $inventaire_troncon_erdf;

    /**
     * @var string
     */
    private $type_equipement_troncon;


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
     * Set dateEquipementTroncon
     *
     * @param \DateTime $dateEquipementTroncon
     * @return TEquipementsTronconsErdf
     */
    public function setDateEquipementTroncon($dateEquipementTroncon)
    {
        $this->dateEquipementTroncon = $dateEquipementTroncon;

        return $this;
    }

    /**
     * Get dateEquipementTroncon
     *
     * @return \DateTime 
     */
    public function getDateEquipementTroncon()
    {
        return $this->dateEquipementTroncon;
    }

    /**
     * Set geom
     *
     * @param geometry $geom
     * @return TEquipementsTronconsErdf
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
     * Set loginSaisie
     *
     * @param string $loginSaisie
     * @return TEquipementsTronconsErdf
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
     * Set geomJson
     *
     * @param array $geomJson
     * @return TEquipementsTronconsErdf
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
     * Set inventaire_troncon_erdf
     *
     * @param string $inventaireTronconErdf
     * @return TEquipementsTronconsErdf
     */
    public function setInventaireTronconErdf($inventaireTronconErdf)
    {
        $this->inventaire_troncon_erdf = $inventaireTronconErdf;

        return $this;
    }

    /**
     * Get inventaire_troncon_erdf
     *
     * @return string 
     */
    public function getInventaireTronconErdf()
    {
        return $this->inventaire_troncon_erdf;
    }

    /**
     * Set type_equipement_troncon
     *
     * @param string $typeEquipementTroncon
     * @return TEquipementsTronconsErdf
     */
    public function setTypeEquipementTroncon($typeEquipementTroncon)
    {
        $this->type_equipement_troncon = $typeEquipementTroncon;

        return $this;
    }

    /**
     * Get type_equipement_troncon
     *
     * @return string 
     */
    public function getTypeEquipementTroncon()
    {
        return $this->type_equipement_troncon;
    }
}
