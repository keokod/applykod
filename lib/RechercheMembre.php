<?php

require_once '../lib/Ini.php';

class RechercheMembre extends Recherche {

    public function __construct($input_recherche) {
    }

    public function autoriseRecherche() {
        //si ne contient pas FF on vérifie les autorisations
        if (!in_array('FF', $this->session_visiteur->getHexaAuthVisiteur())) {
            if ($this->table == 'membre') {// recherche d'un collaborateur
                echo "recherche collabo";
            }
            if ($this->table == 'membre') {// recherche le nom d'un client
                if (in_array('10', $this->auth_visiteur)) {
                    echo "pour rechercher client !!!!!";
                }
            }
        }
    }

    public function findSimpleChamp() {
        $this->autoriseRecherche();
        $query = 'SELECT id,email,nom,prenom FROM ' . $this->table . ' WHERE ' . $this->champ . '  LIKE "%' . $this->mot_cle . '%" ';
        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        $this->session_visiteur->setResultFind($data);
        $this->session_visiteur->refreshVisiteur();
    }

}

/*
 * PROJET STEPHANE NGOV V1.31
 */
?>
