<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TPhotosTronconsErdfView
 */
class TPhotosTronconsErdfView
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $cheminPhoto;

    /**
     * @var string
     */
    private $commentaire;

    /**
     * @var boolean
     */
    private $neutralise;

    /**
     * @var string
     */
    private $auteur;

    /**
     * @var \PNV\CablesBundle\Entity\View\TInventaireTronconsErdfView
     */
    private $inventaire_troncon_erdf;


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
     * Set cheminPhoto
     *
     * @param string $cheminPhoto
     * @return TPhotosTronconsErdfView
     */
    public function setCheminPhoto($cheminPhoto)
    {
        $this->cheminPhoto = $cheminPhoto;

        return $this;
    }

    /**
     * Get cheminPhoto
     *
     * @return string 
     */
    public function getCheminPhoto()
    {
        return $this->cheminPhoto;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return TPhotosTronconsErdfView
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set neutralise
     *
     * @param boolean $neutralise
     * @return TPhotosTronconsErdfView
     */
    public function setNeutralise($neutralise)
    {
        $this->neutralise = $neutralise;

        return $this;
    }

    /**
     * Get neutralise
     *
     * @return boolean 
     */
    public function getNeutralise()
    {
        return $this->neutralise;
    }

    /**
     * Set auteur
     *
     * @param string $auteur
     * @return TPhotosTronconsErdfView
     */
    public function setAuteur($auteur)
    {
        $this->auteur = $auteur;

        return $this;
    }

    /**
     * Get auteur
     *
     * @return string 
     */
    public function getAuteur()
    {
        return $this->auteur;
    }

    /**
     * Set inventaire_troncon_erdf
     *
     * @param \PNV\CablesBundle\Entity\View\TInventaireTronconsErdfView $inventaireTronconErdf
     * @return TPhotosTronconsErdfView
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
     * @var string
     */
    private $id_inventaire_troncon_erdf;


    /**
     * Set id_inventaire_troncon_erdf
     *
     * @param string $idInventaireTronconErdf
     * @return TPhotosTronconsErdfView
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
}
