<?php

require_once '../lib/Ini.php';

class VerifFacture extends Verif {

    public function __construct($input_piece) {
        parent::__construct($input_piece);
    }

    public function verifPiece() {
        $this->validLimitNum($this->input_form['total'], 0, 10,'correction prix total');
        $this->validAlpha($this->input_form['remarque']);
        $nb_erreur = count($this->getCollectErr());
        if($nb_erreur >0)
        {
            return FALSE;
        }
    }
}

?>
