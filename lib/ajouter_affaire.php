<?php
require_once '../lib/Ini.php'; //RECEPTION AJOUTER AFFAIRE
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application

if ($visiteur->getAjouterOrModifier() == 'M') {
    $titre = 'modifier appareil';
} else {
    $titre = 'ajouter affaire';
}

//*************************************** PREPARTATION DE LA PAGE HTML + MENU***PROJET STEPHANE NGOV *************************************
$html = new Html($titre);
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/affaire.css">'); //ajouter le css admin
$html->banniere('affaire :');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$html->navMenu($menu, 'menu_action'); //MENU ACTION
?>
<article>
    <?php
//*************************************** SI ON POST AVEC ID AFFAIRE ON MODIFIE L AFFAIRE *****************
    if (isset($_GET['id_affaire'])) {
        $affaire = new Affaire($_GET['crypt']);
        $data = $affaire->recupficheAffaire($_GET['id_affaire']);   //on récupère les informations pour hyadrater l'appareil
        $client = $visiteur->getResultFind();
    }

//*************************************** SI ON GET ID CLIENT ON AJOUTE UNE AFFAIRE *****************
    if (isset($_GET['id_client'])) {//on modifie l'affaire par get //LE CLIENT EXISTE ON VA AJOUTER UNE AUTRE AFFAIRE
        $id_client = $_GET['id_client'];
        $visiteur->setModeAjouter(); //on vient de la page ajouter affaire
        //on enregistre id_client en mémoire visiteur

        $visiteur->setMemNextAction($id_client);
        $client = $visiteur->getResultFind();
        
        // AFFICHE LE CLIENT QUI DEMANDE UNE REPARATION
        if ($client != NULL) {
            foreach ($client as $R) {
                if ($R->id == $id_client) {
                    $email = $R->email;
                    $nom = $R->nom;
                    $prenom = $R->prenom;
                }
            }
        }
    } else {//PAR POST ON VIENT D ENREGISTERE LE NOUVEAU CLIENT CREATION DE LA NOUVELLE AFFAIRE
        //on efface les résultats 

        $visiteur->clearRecherche();
        $recup_client = new Membre();
        $id_client = $visiteur->getMemNextAction(); //récupération du membre qu'on vient d'enregistrer
        $recup_client->hydrateMembre($id_client);
                echo "<h1>id_cient ******".$id_client."</h1>";
        $client = $recup_client->allAtribut();
        $email = $client['email'];
        $nom = $client['nom'];
        $prenom = $client['prenom'];
    }
    
    //on test si il y a un résultat

    
    ?>
    <h2>info client</h2>

    <ul>
        <li>courriel : <?php echo $email ?></li>
        <li>nom : <?php echo $nom; ?>
        <li>prenom :  <?php echo $prenom; ?></li>
    </ul>
    <?php
    echo "<h3>appareil du client</h3>";

    $form_affaire = new FormAffaire('verif_saisie_affaire.php', $titre);

    if (isset($_GET['id_affaire']) && $visiteur->getAjouterOrModifier() == 'M') {
        
        $form_affaire->hydrateAffaire($data);
    }
    $form_affaire->formInputAppareil();

//on vérifi si le poste n'est pas vide pour hydrater le froumulaire
    $form_affaire->endForm($titre);
    /*
     * PROJET STEPHANE NGOV
     */
    ?>
</article>
</section>
<aside>
    <?php
    $visiteur->getErreur();
    $html->footer();
    ?>