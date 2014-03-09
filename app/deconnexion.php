<?php
require_once'../lib/Ini.php';
session_unset($_SESSION);
session_destroy();

//*************************************** PREPARATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus(
        '<link rel="stylesheet" type="text/css" href=".$this->css_theme."/global.css"> ');
?>
<div id="Off">
    <h1>Vous êtes déconnecté</h1>
    <a href="../public/index.php">page accueil</a>
</div>
