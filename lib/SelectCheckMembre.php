<?php

require_once '../lib/Ini.php';

class SelectCheckMembre extends SelectCheck {

    private $civilite = NULL;
    private $type_user = NULL;
    private $check_auth = array();

    public function __construct($input_form_select_check) {
        parent::__construct($input_form_select_check);
    }

    public function getCheckAuth() {
        extract($this->select_check);
        //autorisation client
        if (isset($add_membre)) {
            $this->check_auth[] = $add_membre;
        }
        if (isset($list_membre)) {
            $this->check_auth[] = $list_membre;
        }
        if (isset($find_membre)) {
            $this->check_auth[] = $find_membre;
        }
        if (isset($fiche_membre)) {
            $this->check_auth[] = $fiche_membre;
        }
        if (isset($edit_membre)) {
            $this->check_auth[] = $edit_membre;
        }
        if (isset($modif_membre)) {
            $this->check_auth[] = $modif_membre;
        }
        if (isset($kill_membre)) {
            $this->check_auth[] = $kill_membre;
        }
        //autorisation receptioniste
        if (isset($add_affaire)) {
            $this->check_auth[] = $add_affaire;
        }
        if (isset($list_affaire)) {
            $this->check_auth[] = $list_affaire;
        }
        if (isset($find_affaire)) {
            $this->check_auth[] = $find_affaire;
        }
        if (isset($fiche_affaire)) {
            $this->check_auth[] = $fiche_affaire;
        }
        if (isset($edit_affaire)) {
            $this->check_auth[] = $edit_affaire;
        }
        if (isset($modif_affaire)) {
            $this->check_auth[] = $modif_affaire;
        }
        if (isset($kill_affaire)) {
            $this->check_auth[] = $kill_affaire;
        }

        //autorisation magasinier
        if (isset($add_piece)) {
            $this->check_auth[] = $add_piece;
        }
        if (isset($list_piece)) {
            $this->check_auth[] = $list_piece;
        }
        if (isset($find_piece)) {
            $this->check_auth[] = $find_piece;
        }
        if (isset($fiche_piece)) {
            $this->check_auth[] = $fiche_piece;
        }
        if (isset($edit_piece)) {
            $this->check_auth[] = $edit_piece;
        }
        if (isset($modif_piece)) {
            $this->check_auth[] = $modif_piece;
        }
        if (isset($plus_piece)) {//ajouter la quantié de pièce
            $this->check_auth[] = $plus_piece;
        }
        if (isset($moins_piece)) {//destocker la quantité de pièces
            $this->check_auth[] = $moins_piece;
        }

        if (isset($kill_piece)) {
            $this->check_auth[] = $kill_piece;
        }
        //autorisation technicien
        if (isset($add_inter)) {
            $this->check_auth[] = $add_inter;
        }
        if (isset($list_inter)) {
            $this->check_auth[] = $list_inter;
        }
        if (isset($find_inter)) {
            $this->check_auth[] = $find_inter;
        }
        if (isset($fiche_inter)) {
            $this->check_auth[] = $fiche_inter;
        }
        if (isset($edit_inter)) {
            $this->check_auth[] = $edit_inter;
        }
        if (isset($modif_inter)) {
            $this->check_auth[] = $modif_inter;
        }
        if (isset($kill_inter)) {
            $this->check_auth[] = $kill_inter;
        }
        
        return $this->check_auth;
    }

    public function getSelectCivilite() {
        switch ($this->select_check) {
            case 0:
                $this->select = "Monsieur";
                break;
            case 1:
                $this->select = "Madame";
                break;
            case 1:
                $this->select = "mademoiselle";
                break;
            default :
                $this->select = "Monsieur";
        }
        return $this->select;
    }

}

?>
