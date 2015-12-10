<?php

namespace PNV\CablesBundle\Entity\View;

use Doctrine\ORM\Mapping as ORM;

/**
 * TPhotosPoteauxErdfView
 */
class TPhotosPoteauxErdfView
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
     * @var \PNV\CablesBundle\Entity\View\TInventairePoteauxErdfView
     */
    private $inventaire_poteau_erdf;

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
     * @return TPhotosPoteauxErdfView
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
     * @return TPhotosPoteauxErdfView
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
     * @return TPhotosPoteauxErdfView
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
     * @return TPhotosPoteauxErdfView
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
     * Set inventaire_poteau_erdf
     *
     * @param \PNV\CablesBundle\Entity\View\TInventairePoteauxErdfView $inventairePoteauErdf
     * @return TPhotosPoteauxErdfView
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
     * Set id_inventaire_poteau_erdf
     *
     * @param string $idInventairePoteauErdf
     * @return TPhotosPoteauxErdfView
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
