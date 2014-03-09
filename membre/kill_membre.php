<?php

require_once '../lib/Ini.php';
extract($_GET);
if (isset($id_kill_membre) & isset($crypt)) {
    $kill_inscription = new Desinscription($crypt);
    $kill_inscription->isExistMembre($id_kill_membre);
} else {
     Route::routage(8001);//action interdit
}
?>
