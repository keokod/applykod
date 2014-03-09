<?php
require_once '../lib/Ini.php'; //INDEX MENU TECHNICIEN
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1);
$menu = $start->getLienMenu();

//*************************************** PREPARATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html('TECHNIQUE :');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/tech.css">'); //ajouter le css admin
$html->banniere('technique :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?><article>
    
<a href="#null" onclick="javascript:history.back();">Précédent</a>
    <?php
//********************vider les anciens inputs *********
    if (empty($_POST) || !isset($_GET)) {
$visiteur->clearInputForm(); //nettoyage des inputs
	}
//********************$_POST = AJOUTER DE L INTERVENTION *********
    if (empty($_POST) && empty($_GET)) {
        $id_affaire = $visiteur->getMemNextAction(); //on récupérer l'id affaire
        $visiteur->setModeAjouter(); // en mode ajouter
        $submit = "ajouter intervention ";
    }

//********************$_POST = AJOUTER DE L INTERVENTION ERREUR SAISIE *********
    if (empty($_POST) && empty($_GET) && $visiteur->getInputForm() != NULL) {
        $form_input = $visiteur->getInputForm();
    }

//********************GET = MODIFCATION DE L INTERVENTION PROVIENT FICHE AFFAIRE PRENDRE EN CHARGE*********
    if (!empty($_GET['id'])) {//id intervention
        $id_affaire = $visiteur->getMemNextAction(); //on récupérer l'id affaire
        $recup_inter = new Intervention();
        $form_input = $recup_inter->recupInter($_GET['id']); //RECHERCHER L INTERVENTION A MODIFIER
        $visiteur->setInputForm($form_input);
        $submit = "modifier intervention";
        $visiteur->setModeModifier();
    }

//********************GET = PROVIENT DE LA PAGE DIRECTE MES INTERVENTIONS AJOUTER INTEVENTION*********
    if (!empty($_GET['id_affaire_tech']) && isset($_GET['crypt'])) {
        //on récupère l'affaire depuis le get
        $recup_affaire = new Affaire($_GET['crypt']);
        $id_affaire = $_GET['id_affaire_tech'];
        $affaire_tech = $recup_affaire->recupficheAffaire($_GET['id_affaire_tech']);
        $visiteur->setResultFind($affaire_tech);
        $visiteur->setModeAjouter();
        $submit = "ajouter intervention";
    }

//**********************AFFICHAGE DES INFORMATIONS SUR L APPAREIL ET LE CLIENT
    $data_aff = $visiteur->getResultFind(); //récupération des donnnées affaire depuis la page fiche reception affaire
    ?>
    <h3>appareil <?php echo $data_aff->reference ?> </h3>
    <div class="appareil">
        <b>numero de serie</b> <?php echo $data_aff->numero_serie ?><br/>
        <b>localisation</b> <?php echo $data_aff->localisation ?><br/>
        <b>client:</b> <?php echo $data_aff->nom ?><br/>
        <b>remarque</b>  <?php echo $data_aff->remarque ?><br/>
    </div>
    <?php
    //DETERMINE LE NOM DU BOUTON, PRIS EN CHARGE DE L APPAREIL OU NOUVELLE INTERVENTION 
    $inter = new Intervention();
    $intervention = $inter->listeInter($id_affaire);
    if (empty($intervention)) {
        $titre_inter = "prendre en charge l'appareil";
        $submit = "prendre en charge";
    } else {
        $titre_inter = "ajouter une intervention";
    }
    $form_inter = new FormIntervention('verif_saisie_intervention.php', $titre_inter);
    if (isset($form_input)) {//si on a poster
        $form_inter->hydratFormInter($form_input);
    }
    $form_inter->add_inter($visiteur->getMemNextAction()); //on récupère le numéro de l'affaire
    $form_inter->endForm($submit);
    ?>
    <h1><a href="cloture_inter.php">terminer la réparation</a></h1>
</article>
</section>
<aside><!-- balise aside fermante dans le footer -->
<?php
$visiteur->getErreur();
$html->footer();
