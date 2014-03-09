<?php

class menuAction {

    private $sous_menu = array();
    private $action;

    public function __construct($array_hexa_auth) {

        foreach ($array_hexa_auth as $H) {

            switch (hexdec($H)) {
                //sous menu receptionniste 
                case 16://10
                    $sous_menu[] = array('url' => '../membre/ajouter_client.php', 'lien' => 'ajouter client');
                    break;
                case 17://11
                    $sous_menu[] = array('url' => '../membre/lister_client.php', 'lien' => 'lister client');
                    break;
                case 19://12
                    $sous_menu[] = array('url' => '../app/moteur_recherche.php', 'lien' => 'rechercher un client');
                    break;
                case 18://13
                    $sous_menu[] = array('url' => '../app/fiche_client.php', 'lien' => 'fiche client');
                    break;
                case 19://14
                    $sous_menu[] = array('url' => '../app/editer_client.php', 'lien' => 'editer un client');
                    break;

                case 20://15
                    $sous_menu[] = array('url' => '../membre/modifier_client.php', 'lien' => 'bannir client');
                    break;
                case 30://1E
                    $sous_menu[] = array('url' => '../membre/bannir_client.php', 'lien' => 'bannir client');
                    break;
                case 31://1F
                    $sous_menu[] = array('url' => '../membre/supprimer_client.php', 'lien' => 'supprimer client');
                    break;

                //
                case 32://20
                    $sous_menu[] = array('url' => '../reception/ajouter_affaire.php', 'lien' => 'fiche client');
                    break;
                case 33://21
                    $sous_menu[] = array('url' => '../reception/lister_affaire.php', 'lien' => 'fiche client');
                    break;
                case 34://22
                    $sous_menu[] = array('url' => '../reception/rechercher_affaire.php', 'lien' => 'fiche client');
                    break;
                case 35://23
                    $sous_menu[] = array('url' => '../reception/detail_affaire.php', 'lien' => 'détail_affaire');
                    break;
                case 36://24
                    $sous_menu[] = array('url' => '../reception/editer_affaire.php', 'lien' => 'mode edtion affaire');
                    break;
                case 37://25
                    $sous_menu[] = array('url' => '../reception/modifier_affaire.php', 'lien' => 'modifier affaire');
                    break;
                case 47://2F
                    $sous_menu[] = array('url' => '../reception/supprimer_affaire.php', 'lien' => 'supprimer affaire');
                    break;

                //stock
                case 48://48
                    $sous_menu[] = array('url' => '../stock/ajouter_piece.php', 'lien' => 'ajouter pièce');
                    break;
                case 49://43
                    $sous_menu[] = array('url' => '../stock/lister_piece.php', 'lien' => 'liste piece');
                    break;
                case 50://50
                    $sous_menu[] = array('url' => '../stock/rechercher_piece.php', 'lien' => 'rechercher une piece');
                    break;
                case 51://51
                    $sous_menu[] = array('url' => '../stock/fiche_piece.php', 'lien' => 'fiche piece');
                    break;
                case 52://52
                    $sous_menu[] = array('url' => '../stock/editer_piece.php', 'lien' => 'mode edtion affaire');
                    break;
                case 53://53
                    $sous_menu[] = array('url' => '../stock/modifier_piece.php', 'lien' => 'modifier affaire');
                    break;
                case 54://54
                    $sous_menu[] = array('url' => '../stock/moins_quantite_piece.php', 'lien' => 'déstocker quantité pièce');
                    break;
                case 55://55
                    $sous_menu[] = array('url' => '../stock/plus_quantite_piece.php', 'lien' => 'ajouter une quantié pièce');
                    break;
                case 63://3F
                    $sous_menu[] = array('url' => '../stock/suprimer_piece.php', 'lien' => 'supprimer la pièce');
                    break;
                //technicien
                case 64://40
                    $sous_menu[] = array('url' => '../tecnique/ajouter_intervention.php', 'lien' => 'tache sur appareil');
                    break;
                case 65://41
                    $sous_menu[] = array('url' => '../tecnique/liste_intervention.php', 'lien' => 'liste intervention');
                    break;
                case 66://42
                    $sous_menu[] = array('url' => '../tecnique/rechercher_intervention.php', 'lien' => 'rechercher une tâche');
                    break;
                case 67://43
                    $sous_menu[] = array('url' => '../tecnique/detail_intervention.php', 'lien' => 'histoirique des tâche ');
                    break;
                case 68://44
                    $sous_menu[] = array('url' => '../tecnique/editer_intervention.php', 'lien' => 'editer une tâche');
                    break;
                case 69://45
                    $sous_menu[] = array('url' => '../tecnique/modifier_intervention.php', 'lien' => 'modifer une des tâches ');
                    break;
                case 79://4F
                    $sous_menu[] = array('url' => '../tecnique/supprimer_intervention.php', 'lien' => 'supprimer une intervention ');
                    break;

                // SU
                case 80://50
                    $sous_menu[] = array('url' => '../membre/ajouter_employe.php', 'lien' => 'ajouter un collaborteur');
                    break;
                case 81://50
                    $sous_menu[] = array('url' => '../membre/liste_employe.php', 'lien' => 'liste des employés');
                    break;
                case 82://51
                    $sous_menu[] = array('url' => '../membre/recherche_employe.php', 'lien' => 'recherche employé');
                    break;
                case 83://52
                    $sous_menu[] = array('url' => '../membre/fiche_employe.php', 'lien' => 'fiche employé');
                    break;
                case 84://53
                    $sous_menu[] = array('url' => '../membre/editer_employe', 'lien' => 'editer la fiche employé');
                    break;
                case 85://54
                    $sous_menu[] = array('url' => '../membre/modifier_employe.php', 'lien' => 'modifer un employe ');
                    break;
                case 94://5E
                    $sous_menu[] = array('url' => '../membre/bannir_employe.php', 'lien' => 'bannir un employe ');
                    break;

                case 95://5F
                    $sous_menu[] = array('url' => '../membre/supprimer_employe.php', 'lien' => 'supprimé employé');
                    break;
            }
        }
    }

}

?>
