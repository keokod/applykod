<?php

require_once '../lib/Ini.php';

class VerifToken extends Verif {

    const duree_token = 600; //fixe la durée du jeton

    public function __construct($crypt) {//récupère le crypt du jeton
        $timestamp = time();
        $token_visiteur = $_SESSION['visiteur']->getToken(); //récupère le jeton session
        $session_crypt = $token_visiteur['crypt'];
        $session_jeton_time_created = $token_visiteur['time_create'];
        $time_max = VerifToken::duree_token + $session_jeton_time_created;
        //si le jeton n'est pas bon erreur de jeton
        if (!($time_max > $timestamp && $session_crypt == $crypt)) {//si la date limit dépasse la date actuelle
            $_SESSION['visiteur']->setErreur(array("session terminé ou erreur de connexion"));
           Route::routage(8000); //si jeton mauvais erreur jeton
        }
    }

}

/*
 * PROJET STEPHANE NGOV V0.80
 */
?>
