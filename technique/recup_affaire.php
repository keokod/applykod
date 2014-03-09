<?php
require_once '../lib/Ini.php'; //LIST DES AFFAIRES DU TECHNICEN
if($_GET['id_affaire'])
{
    $visiteur = $_SESSION['visiteur'];
    Route::routage(6001);
    
}
else
{
    echo "erreur jeton";
}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
