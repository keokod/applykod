<?php

require_once '../lib/Ini.php';

class FormRechercheMembre extends FormRecherche {

    private $recherche_type_user = NULL; //sois membre, soit client

    public function __construct() {
        $titre_form = "rechercher le nom (famille) d 'un membre";
        parent::__construct($this->cible_verif_saisie_recherche, $titre_form);
        $this->table = "membre";
        $this->champ = "nom";
        $this->recherche_type_user = $this->session_visiteur->getHexaAuthVisiteur();
        $this->formRecherche();
        
    }

    public function choixTypeMembre() {//on laisse le choix de recherche sur le type du membre
        ?>
        <select name="condition">
            <option value="1">client</option>
            <option value="2">Collaborateur</option>
        </select><br/>

        <?php
    }

}
/*
 * PROJET STEPHANE NGOV
 */
?>