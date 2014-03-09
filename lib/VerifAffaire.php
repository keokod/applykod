<?php

require_once '../lib/Ini.php';

class VerifAffaire extends Verif {

    public function __construct($input_affaire) {
        parent::__construct($input_affaire);
    }

    public function verifFicheAffaire() {
        $this->validLimitStr($this->input_form['ref_appareil'], 3,255, 'reférence appareil');
        $this->validAlphaNum($this->input_form['ref_appareil']);
        $this->validLimitStr($this->input_form['num_serie'], 3,255, 'numéro de série');
        $this->validAlphaNum($this->input_form['num_serie']);
        
        $this->validAlphaNum($this->input_form['localisation']);
        
        $this->validAlphaNum($this->input_form['remarque']);
        
        $nb_erreur = count($this->getCollectErr());
        if ($nb_erreur == 0) {//si pas d'erreur on enrgistre l'affaire
            return TRUE;
        }
        $_SESSION['visiteur']->setErreur($this->collect_err); //si erreur on recommence
        Route::routage(4000);
    }

}

?>
