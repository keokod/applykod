<?php

require_once '../lib/Ini.php';

class VerifIntervention extends Verif {

    public function __construct($input_affaire) {
        parent::__construct($input_affaire);
    }

    public function verifInter() {
        //vérifier l'heure
        $this->validAlphaNum($this->input_form['diagnostique']);
        $this->validAlphaNum($this->input_form['tache']);
        $this->isEntier($this->input_form['duree']);
        $this->validLimitNum($this->input_form['duree'], 0, 100, 'duree');
        
        $this->validLimitNum($this->input_form['etat'], 1, 5, 'etat intervention');
        $nb_erreur = count($this->getCollectErr());
        if ($nb_erreur > 0) {//si erreur on redirection au formulaire
            return FALSE;
        }
    }

}

?>
