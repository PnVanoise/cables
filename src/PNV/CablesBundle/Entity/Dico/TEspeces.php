<?php

namespace PNV\CablesBundle\Entity\Dico;

use Doctrine\ORM\Mapping as ORM;

/**
 * TEspeces
 */
class TEspeces
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var integer
     */
    private $taille_zone_tampon;

    /**
     * @var string
     */
    private $code_couleur;


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
     * Set libelle
     *
     * @param string $libelle
     * @return TEspeces
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set taille_zone_tampon
     *
     * @param integer $tailleZoneTampon
     * @return TEspeces
     */
    public function setTailleZoneTampon($tailleZoneTampon)
    {
        $this->taille_zone_tampon = $tailleZoneTampon;

        return $this;
    }

    /**
     * Get taille_zone_tampon
     *
     * @return integer 
     */
    public function getTailleZoneTampon()
    {
        return $this->taille_zone_tampon;
    }

    /**
     * Set code_couleur
     *
     * @param string $codeCouleur
     * @return TEspeces
     */
    public function setCodeCouleur($codeCouleur)
    {
        $this->code_couleur = $codeCouleur;

        return $this;
    }

    /**
     * Get code_couleur
     *
     * @return string 
     */
    public function getCodeCouleur()
    {
        return $this->code_couleur;
    }
}
