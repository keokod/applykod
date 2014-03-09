<?php

class aCocher {

    private $a_cocher = array();

    public function __construct($a_poster_cocher) {
        extract($a_poster_cocher);
        //autorisation client
        if (isset($add_membre)) {
            $this->a_cocher[] = $add_membre;
        }
        if (isset($list_membre)) {
            $this->a_cocher[] = $list_membre;
        }
        if (isset($find_membre)) {
            $this->a_cocher[] = $find_membre;
        }
        if (isset($fiche_membre)) {
            $this->a_cocher[] = $fiche_membre;
        }
        if (isset($edit_membre)) {
            $this->a_cocher[] = $edit_membre;
        }
        if (isset($modif_membre)) {
            $this->a_cocher[] = $modif_membre;
        }
        if (isset($kill_membre)) {
            $this->a_cocher[] = $kill_membre;
        }
        //autorisation receptioniste
        if (isset($add_affaire)) {
            $this->a_cocher[] = $add_affaire;
        }
        if (isset($list_affaire)) {
            $this->a_cocher[] = $list_affaire;
        }
        if (isset($find_affaire)) {
            $this->a_cocher[] = $find_affaire;
        }
        if (isset($fiche_affaire)) {
            $this->a_cocher[] = $fiche_affaire;
        }
        if (isset($edit_affaire)) {
            $this->a_cocher[] = $edit_affaire;
        }
        if (isset($modif_affaire)) {
            $this->a_cocher[] = $modif_affaire;
        }
        if (isset($kill_affaire)) {
            $this->a_cocher[] = $kill_affaire;
        }

        //autorisation magasinier
        if (isset($add_piece)) {
            $this->a_cocher[] = $add_piece;
        }
        if (isset($list_piece)) {
            $this->a_cocher[] = $list_piece;
        }
        if (isset($find_piece)) {
            $this->a_cocher[] = $find_piece;
        }
        if (isset($fiche_piece)) {
            $this->a_cocher[] = $fiche_piece;
        }
        if (isset($edit_piece)) {
            $this->a_cocher[] = $edit_piece;
        }
        if (isset($modif_piece)) {
            $this->a_cocher[] = $modif_piece;
        }
        if (isset($plus_piece)) {//ajouter la quantié de pièce
            $this->a_cocher[] = $plus_piece;
        }
        if (isset($moins_piece)) {//destocker la quantité de pièces
            $this->a_cocher[] = $moins_piece;
        }

        if (isset($kill_piece)) {
            $this->a_cocher[] = $kill_piece;
        }

        //autorisation technicien
        if (isset($add_inter)) {
            $this->a_cocher[] = $add_inter;
        }
        if (isset($list_inter)) {
            $this->a_cocher[] = $list_inter;
        }
        if (isset($find_inter)) {
            $this->a_cocher[] = $find_inter;
        }
        if (isset($fiche_inter)) {
            $this->a_cocher[] = $fiche_inter;
        }
        if (isset($edit_inter)) {
            $this->a_cocher[] = $edit_inter;
        }
        if (isset($modif_inter)) {
            $this->a_cocher[] = $modif_inter;
        }
        if (isset($kill_inter)) {
            $this->a_cocher[] = $kill_inter;
        }

    }
    
    public function getA_Cocher()
    {
        return $this->a_cocher;
    }

}

?>
