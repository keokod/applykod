<?php
require_once'../lib/Ini.php';

//*************************************** PREPARATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus(
        '<link rel="stylesheet" type="text/css" href=".$this->css_theme."/global.css"> ');

$appareil = new Appareil();
$appareil->sortirAppareil($_GET['id_appareil']);
?>

<h1>appareil sorie</h1>

<input type="button" value="Revenir en arrière" onclick="window.history.back()">
