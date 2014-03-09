<?php
require_once '../lib/Ini.php';
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 5); //5 = ADMINISTRATION

if (!in_array('FF', $visiteur->getHexaAuth())) {//si ce n'est pas un SU directe erreur
    Route::routage(8001); //redirection erreur
}

//on vérifie que les saisies son correcte
$verif = new verifChampMembre();
$champ_verifer = $verif->verifChampAnnuaire($_POST);

if ($champ_verifer === TRUE) {
    $a_cocher = new aCocher($_POST);
    $result_cocher = $a_cocher->getA_Cocher();
    // $inscrire_membre=new Inscription();
    // $inscrire_membre->inscrireMembre($membre);
    echo "on peut enregistrer";
} else {//si il y a erreur on récupère la sasie et on représente le formulaire
    echo "erreur de saisie";
    $membre = new Membre();
    $membre->hydratModifMembre($_POST); //on hydrate les champs remplit 
    $visiteur->refreshVisiteur();
    Route::routage(7000); //recommencer ajoutre_membre.php
}
?>

<h1>enregister le membre</h1>
