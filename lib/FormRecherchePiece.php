<?php

require_once '../lib/Ini.php';

class FormRecherchePiece extends FormRecherche {

    public function __construct() {
        $titre_form = "recherche pièce";
        parent::__construct('../magasin/verif_recherche_piece.php', $titre_form);
        $this->table = "stock";
        $this->champ = "reference";
    }
    
    public function findPiece()
    {
        $this->formRecherche();
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>