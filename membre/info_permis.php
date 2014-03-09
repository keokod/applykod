<?php
require_once '../lib/Ini.php';; //  ADMIN/INDEX.PHP


$html = new Html('Administration');
$html->headPlus('
        <link rel=stylesheet type="text/css" href="../css/membre.css">
        ');
$service = array(
    'administrateur'=>'Administrateur.php',
    'SAV'=>'Technicien.php');

$html->header($service);//menu horizontal

$action = array(
    'administration'=>'Administrateur.php',
    'technicien'=>'Technicien.php',
    'facturartion'=>'facture.php');

$html->section($action);//menu vertical



echo "artivle ************************";
$html->footer();

?>
