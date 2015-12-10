<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEquipementsTronconsErdfView
 */
class TEquipementsTronconsErdfView
{
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
    private $id_inventaire_troncon_erdf;

    /**
     * @var string
     */
    private $id_type_equipement_troncon;
    

    /**
     * @var \PNV\CablesBundle\Entity\View\TInventaireTronconsErdfView
     */
    private $inventaire_troncon_erdf;

    /**
     * @var \PNV\CablesBundle\Entity\Dico\DicoTypeEquipementTroncon
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
     * @return TEquipementsTronconsErdfView
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
     * @return TEquipementsTronconsErdfView
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
     * @return TEquipementsTronconsErdfView
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
     * @return TEquipementsTronconsErdfView
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
     * @param \PNV\CablesBundle\Entity\View\TInventaireTronconsErdfView $inventaireTronconErdf
     * @return TEquipementsTronconsErdfView
     */
    public function setInventaireTronconErdf(\PNV\CablesBundle\Entity\View\TInventaireTronconsErdfView $inventaireTronconErdf = null)
    {
        $this->inventaire_troncon_erdf = $inventaireTronconErdf;

        return $this;
    }

    /**
     * Get inventaire_troncon_erdf
     *
     * @return \PNV\CablesBundle\Entity\View\TInventaireTronconsErdfView 
     */
    public function getInventaireTronconErdf()
    {
        return $this->inventaire_troncon_erdf;
    }

    /**
     * Set type_equipement_troncon
     *
     * @param \PNV\CablesBundle\Entity\Dico\DicoTypeEquipementTroncon $typeEquipementTroncon
     * @return TEquipementsTronconsErdfView
     */
    public function setTypeEquipementTroncon(\PNV\CablesBundle\Entity\Dico\DicoTypeEquipementTroncon $typeEquipementTroncon = null)
    {
        $this->type_equipement_troncon = $typeEquipementTroncon;

        return $this;
    }

    /**
     * Get type_equipement_troncon
     *
     * @return \PNV\CablesBundle\Entity\Dico\DicoTypeEquipementTroncon 
     */
    public function getTypeEquipementTroncon()
    {
        return $this->type_equipement_troncon;
    }
    


    /**
     * Set id_inventaire_troncon_erdf
     *
     * @param string $idInventaireTronconErdf
     * @return TEquipementsTronconsErdfView
     */
    public function setIdInventaireTronconErdf($idInventaireTronconErdf)
    {
        $this->id_inventaire_troncon_erdf = $idInventaireTronconErdf;

        return $this;
    }

    /**
     * Get id_inventaire_troncon_erdf
     *
     * @return string 
     */
    public function getIdInventaireTronconErdf()
    {
        return $this->id_inventaire_troncon_erdf;
    }

    /**
     * Set id_type_equipement_troncon
     *
     * @param string $idTypeEquipementTroncon
     * @return TEquipementsTronconsErdfView
     */
    public function setIdTypeEquipementTroncon($idTypeEquipementTroncon)
    {
        $this->id_type_equipement_troncon = $idTypeEquipementTroncon;

        return $this;
    }

    /**
     * Get id_type_equipement_troncon
     *
     * @return string 
     */
    public function getIdTypeEquipementTroncon()
    {
        return $this->id_type_equipement_troncon;
    }
}
