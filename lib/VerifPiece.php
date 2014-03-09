<?php

require_once '../lib/Ini.php';

class VerifPiece extends Verif {

    public function __construct($input_piece) {
        parent::__construct($input_piece);
    }

    public function verifPiece() {
        $this->validAlphaNum($this->input_form['id_piece']);
        $this->validAlphaNum($this->input_form['nom']);
        $this->validAlphaNum($this->input_form['reference']);
        $this->validIsFloat($this->input_form['quantite']);
        $this->validAlphaNum($this->input_form['fournisseur']);
        $this->validIsFloat($this->input_form['prix_ht']);
        $this->validIsFloat($this->input_form['localisation']);
        $this->validIsFloat($this->input_form['caracteristique']);
        $this->validIsFloat($this->input_form['dimension']);
        
        $nb_erreur = count($this->getCollectErr());
        if($nb_erreur >0)
        {
            return FALSE;
        }
    }
}

?>
