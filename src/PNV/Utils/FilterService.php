<?php

namespace PNV\Utils;

class FilterService{

    /*
     * Service pour définir les listes déroulantes dans les tableaux et formulaires
     */
    private $db;
    private $norm;

    public function __construct($db, $norm){
        $this->db = $db;
        $this->norm = $norm;
    }

#1-- Définition de la liste de sélection #Nom Espece
    public function get_espece($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\TEspeces');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
#2-- Définition de la liste de sélection #Cause Mortalité
    public function get_causeMort($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoCauseMortalite');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
#3-- Définition de la liste de sélection #Age
    public function get_age($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoAge');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
#4-- Définition de la liste de sélection #Sexe
    public function get_sexe($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoSexe');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
#5-- Définition de la liste de sélection #Source
    public function get_source($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoSource');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
#6-- Définition de la liste de sélection #Type d'équipement
    public function get_typeEquipPoteaux($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoTypeEquipementPoteau');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
#7-- Définition de la liste de sélection #Nbre d'équipement
    public function get_nbrEquipPoteaux($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoNbEquipements');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }

#8-- Définition de la liste de sélection #Type d'équipement
    public function get_typeEquipTroncons($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoTypeEquipementTroncon');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }

#9-- Définition de la liste de sélection #Risque poteau et troncons
    public function get_risque($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoClassesRisque');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }

#10-- Définition de la liste de sélection #Type d'équipement
    public function get_typePoteau($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:Dico\DicoTypePoteauErdf');
        $res = $repo->findAll();
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }

#11-- Définition de la liste de sélection #Nom commune
    public function get_commune($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TCommunes');
        $res = $repo->findBy(array(), array('nomCommune'=>'ASC'));
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getNomCommune());
        }
        return $data;
    }

#12-- Définition de la liste de sélection #Nom commune
    public function get_zs($nullable=true){
        $repo = $this->db->getRepository('PNVCablesBundle:View\TZonesSensibles');
        $res = $repo->findBy(array(), array('libelle'=>'ASC'));
        $data = array();
        if($nullable){
            $data[] = array('id'=>0, 'libelle'=>'');
        }
        foreach($res as $elem){
                $data[] = array(
                    'id'=>$elem->getId(),
                    'libelle'=>$elem->getLibelle());
        }
        return $data;
    }
    
}
