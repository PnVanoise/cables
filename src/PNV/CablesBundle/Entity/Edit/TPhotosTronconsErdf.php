<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;

/**
 * TPhotosTronconsErdf
 */
class TPhotosTronconsErdf
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
     * @var string
     */
    private $id_inventaire_troncon_erdf;


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
     * @return TPhotosTronconsErdf
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
     * @return TPhotosTronconsErdf
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
     * @return TPhotosTronconsErdf
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
     * @return TPhotosTronconsErdf
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
     * Set id_inventaire_troncon_erdf
     *
     * @param string $idInventaireTronconErdf
     * @return TPhotosTronconsErdf
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
