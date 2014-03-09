<?php

class Verif {

    protected $input_form = NULL; //les champs post ou get à vérifier
    protected $collect_err = array(); //table des erreurs

    public function __construct($input_form) {//les champs saisie
        $this->input_form = $input_form;
    }

    public function verifDateSql($date_sql) {//on vérfie la date au format SQL (2013-12-58)
        //$date = DateTime::createFormat('Y-m-d', '2012-11-10');
    }

    public function getCollectErr() {
        return $this->collect_err;
    }

    public function validIsFloat($float) {
        $input = filter_var($float, FILTER_VALIDATE_FLOAT);

        if ($input == FALSE) {
            $this->collect_err[] = $float . " n'est pas un nombre décimale ";
        }
    }

    public function isEntier($entier) {
        $verif_entier = is_numeric($entier);
        if ($verif_entier === FALSE) {
            $this->collect_err[] = $entier . " n'est pas un nombre entier ";
        }
    }

    public function validAlpha($alpha) {//verifi chaine
        if (preg_match("#[a-zA-Z]#", $alpha)) {
            return TRUE;
        } else {
            $this->collect_err[] = $alpha . " n'est pas un prénom ou nom de famille valide ";
        }
    }

    public function validAlphaNum($alpah_num) {//chiffre + lettre
				
        if (preg_match("#^[^ ][a-zA-Z0-9._\s à'éèç'-]*$#", $alpah_num)) {
            return TRUE;
        } else {
            $this->collect_err[] = $alpah_num . " est une  invalide, ne pas mettre de caractère spéciaux ";
        }
    }

    public function validLimitNum($id_num, $min, $max, $quoi) {//vérifie les limites de nombre
        if ($id_num < $min || $id_num >= $max) {
            $this->collect_err[] = "le numéro $id_num de sélection $quoi dépasse $max";
        }
    }

    public function validLimitStr($str, $min, $max, $quoi) {//vérifier le nombre min et max de caractère
        $count_str = strlen($str);
        if ($count_str < $min || $count_str > $max) {
            $this->collect_err[] = $quoi . "  dit être compris entre" . $min . " et " . $max . " caratère(s)";
        }
    }

}

/*
 * PROJET STEPHANE NGOV V0.80
 */
$date_sql = "2012-11-31";
$verif = new Verif('');
$verif->verifDateSql($date_sql);
?>
