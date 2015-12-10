<?php

namespace PNV\CablesBundle\Entity\Edit;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * TPhotosPoteauxErdf
 */
class TPhotosPoteauxErdf
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
     * Set cheminPhoto
     *
     * @param string $cheminPhoto
     * @return TPhotosPoteauxErdf
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
     * @return TPhotosPoteauxErdf
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
     * @return TPhotosPoteauxErdf
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
     * @return TPhotosPoteauxErdf
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
     * Set id_inventaire_poteau_erdf
     *
     * @param string $idInventairePoteauErdf
     * @return TPhotosPoteauxErdf
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
