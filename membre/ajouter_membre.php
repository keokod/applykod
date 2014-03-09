<?php
require_once '../lib/Ini.php'; //AJOUTER OU MODIFIER UN MEMBRE SOUS SU

$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 50); //context 50 ajouter membre
$type_user_visiteur = $visiteur->getTypeUserVisiteur(); //on détermine le type du visiteur
$type_user = $visiteur->getTypeUserConcerne(); //!on détermine cilent ou membre

if($visiteur->getAjouterOrModifier() =='M')
{
        $visiteur->setModeModifier(); 
}

//MODIFIER LE MEMBRE CLIENT OU COLLABORATEUR PAR GET CLIQUE PAR LIEN
if (isset($_GET['id_membre'])) {
        $visiteur->setModeModifier(); 
    $titre = "Modifier membre";
    $id_membre = $_GET['id_membre'];
    $submit = "modifier ";
}

//MODIFIER LES CHAMPS FORMULAIRE PAR BOUTON ENVOYER DU COLLABORATEUR OU DU CLIENT
if (isset($_POST['do_modifier'])) {
    $titre = "Modifier membre";
    $id_membre = $visiteur->getMemNextAction(); //id_membre à modifier
    $submit = "modifier " ;
}

//AJOUTER LES COLLABORATEUR OU DES CLIENTS EXISTANT PAR LE MODE EDITION
if (!isset($_GET['id_membre']) && !isset($_POST['modif']) && !isset($_POST['do_modifier'])
        && $visiteur->getAjouterOrModifier() !='M') {//AJOUTER un membre
    $visiteur->setModeAjouter(); //en mode ajouter si pas d'id_membre et post modif
    $titre = "ajouter nouveau membre";
    $id_membre = NULL; //id membre est null on ne le connait pas encore
    $submit = "ajouter " ;
}
 else {
    $id_membre = $visiteur->getMemNextAction(); //id_membre à modifier
    $submit = "modifier ";
}

$visiteur->setMemNextAction($id_membre); //on garde le numéro du membre pour la prochaine action
$menu = $start->getLienMenu();
$html = new Html("MEMBRE : ");
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/affaire.css">'); //ajouter le css 
$html->banniere('Menu Application SAV');
$html->navCategorie($start->getLienCategorie());
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>

<article>
<?php
if ($type_user_visiteur == "SU") {
    $visiteur->setNextRoute(7001); //reussite du formulaire demande route fiche membre normal 7001
    $form_membre = new FormAnnuaire('../membre/valid_saisie_membre.php', $titre, 'annuaire');
} else {
    $visiteur->setNextRoute(4000); //reussite du formulaire demande route fiche client
    $form_membre = new FormAnnuaire('../client/valid_saisie_client.php', $titre, 'annuaire');
}

//si erreur de champs ajouter on hydrate à nouveau le formulaire avec le post
if ($visiteur->getInputForm() != NULL && $visiteur->getAjouterOrModifier() == 'A') {
    $post_hydrate = $visiteur->getInputForm();
    $hexa_auth_membre = $visiteur->getInputHexaMembreConcerne();
    $form_membre->hydrateFormMembre($post_hydrate, $hexa_auth_membre); //on préremplit les champs qui ont été saisie 
}

//on recherch le id_membred ans la session
if ($id_membre != NULL && $visiteur->getAjouterOrModifier() == 'M') { //si on a tranmis le numéro du membre , on le connais et on l'hydrate


    $modif_membre = new Membre();
    $modif_membre->hydrateMembre($id_membre);
    //on récupère les données du membre ayant ce id_membre
    $post_hydrate = $modif_membre->allAtribut();
    $hexa_auth_membre = $post_hydrate['hexa_auth']; //autorisation récupérer
    $form_membre->hydrateModifierMembre($id_membre); //on préremplis en recherche le membre correspondant à id_membre
}

if ($type_user_visiteur == "SU") {
    $form_membre->formEmployer(); //on affiche tous les champs à remplir
} else {
    $form_membre->formClient();
}

$form_membre->endForm($submit);
//PROJET STEPHANE NGOV V1.29
?>
</article>
</section>
<aside><!-- balise aside fermante dans le footer -->
<?php
$visiteur->getErreur();
$html->footer();
?>
