<?php

require_once '../lib/Ini.php'; //RETRANCHER LES PIECES EN STOCK
if (isset($_GET['id_piece']) && isset($_GET['quantite'])) {
    $id_piece = $_GET['id_piece'];
    $quantite = $_GET['quantite'];
    $piece = new Piece();
    if (isset($_GET['moins'])) {
        $piece->moinUn($id_piece, $quantite);
    } else {
        $piece->plusUn($id_piece, $quantite);
    }
}
Route::routage(5003); //retour liste des pièces
?>
