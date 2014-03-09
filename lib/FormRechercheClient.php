<?php

require_once '../lib/Ini.php';

class FormRechercheClient extends FormRechercheMembre {

    private $recherche_type_user = NULL; //sois membre, soit client

    public function __construct() {
        $titre_form = "rechercher client";
        parent::__construct('../client/recherche_client.php', $titre_form);
        ?>
        <select name="condition" class="cache">
            <option value="1">client</option>
        </select>
        <?php
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>