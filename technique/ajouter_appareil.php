<?php
    $form_affaire = new FormAffaire('verif_saisie_affaire.php', 'compléter fiche appareil');
    
    if(isset($_GET['id_affaire']) && $visiteur->getAjouterOrModifier() =='M')
    {
        $form_affaire->hydrateAppareil($data);
    }
    $form_affaire->formInputAppareil();

//on vérifi si le poste n'est pas vide pour hydrater le froumulaire
    $form_affaire->endForm('enregistrer affaire');
?>
