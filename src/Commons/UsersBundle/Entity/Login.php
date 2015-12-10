<?php

namespace Commons\UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Login
 */
class Login
{
    /**
     * @var integer
     */
    private $id_role;

    /**
     * @var string
     */
    private $identifiant;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $nom_complet;

    /**
     * @var integer
     */
    private $id_application;

    /**
     * @var integer
     */
    private $maxdroit;


    /**
     * Get id_role
     *
     * @return integer 
     */
    public function getIdRole()
    {
        return $this->id_role;
    }

    /**
     * Set identifiant
     *
     * @param string $identifiant
     * @return Login
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string 
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return Login
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set nom_complet
     *
     * @param string $nomComplet
     * @return Login
     */
    public function setNomComplet($nomComplet)
    {
        $this->nom_complet = $nomComplet;

        return $this;
    }

    /**
     * Get nom_complet
     *
     * @return string 
     */
    public function getNomComplet()
    {
        return $this->nom_complet;
    }

    /**
     * Set id_application
     *
     * @param integer $idApplication
     * @return Login
     */
    public function setIdApplication($idApplication)
    {
        $this->id_application = $idApplication;

        return $this;
    }

    /**
     * Get id_application
     *
     * @return integer 
     */
    public function getIdApplication()
    {
        return $this->id_application;
    }

    /**
     * Set maxdroit
     *
     * @param integer $maxdroit
     * @return Login
     */
    public function setMaxdroit($maxdroit)
    {
        $this->maxdroit = $maxdroit;

        return $this;
    }

    /**
     * Get maxdroit
     *
     * @return integer 
     */
    public function getMaxdroit()
    {
        return $this->maxdroit;
    }
}
