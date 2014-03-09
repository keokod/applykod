<?php
require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
//  header('Location: ../technique/fiche_intervention.php?id_affaire_tech=' . $id_affaire . '&crypt=' . $visiteur->getCrypt() . ''); //rechercher un client -->
$piece = new Piece();

$erreur = FALSE;
$_SESSION['erreur'] = array();

foreach($_POST as $key=>$qte)
{
    echo "pièce numero : ".$key."<br/>";
    $dispo = $piece->dispoPiece($key, $qte);
    echo $dispo;
    if($dispo < 1)
    {
        echo "pièce indispo";
        $erreur = 1;
    }

}

if($erreur == FALSE)// si false ok on redirige vers la page des résumer affaire
{
    Route::routage(6004);//vers la page des résumer affaire;
}
else
{
    $visiteur->setInputForm($_POST);
    echo '<h1> erreur redirection </h1>';

}

    var_dump($visiteur);
