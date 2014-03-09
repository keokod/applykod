<?php

require_once '../lib/Ini.php';
$_SESSION['panier'][] = $_GET['id_piece']; //charge les paniers
header('Location: rechercher_piece.php?motcle='.$_GET['motcle'].'');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
