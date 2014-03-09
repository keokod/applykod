<?php

class startIndex {

    private $erreur;
    private $lien_categorie = NULL; //le menu horizontaux permis
    private $lien_menu = NULL; //les actions permises
    private $context = NULL; //le contexte de la page
    private $css_admin = NULL;

    public function __construct($visiteur, $context) {
        $this->context = $context;

        if (($visiteur) === NULL) {//tentative d'accès sans se logger
            Route::routage(8000);
        }
        $attribut = $visiteur->allAtributVisiteur();
        $hexa_auth_visiteur = $attribut['hexa_auth_visiteur'];

        //si aucun autorisation = modifier la permière connexion, modifer le membre SU
        if ($hexa_auth_visiteur == NULL) {//si aucun autorisation = modifier la permière connexion
            $visiteur->setHexaAuthVisiteur(array('XX')); //XX = cas particuler forcer la modifiction du SU
            $visiteur->refreshVisiteur();
            Route::routage(9999); //forcer la modification du compte
        }
        //si je suis un compte normal je test les autorisations
        if (!in_array('FF', $hexa_auth_visiteur)) {//filtrer les autorisations selon le contexte
            //***********************COMPTE NORMAL*******************
            //on détermine ses droits
            $hexa_auth_visiteur_menu = $visiteur->getHexaAuthVisiteur();
            //on détermine les accès au détégories
            $hexa_auth_visiteur_categorie = array();
            foreach ($hexa_auth_visiteur as $H) {
                $hexa_auth_visiteur_categorie[] = $H[0]; //1er bit = la catégorie
            }
            //on supprime les doulons
            $hexa_auth_visiteur_categorie = array_unique($hexa_auth_visiteur_categorie);
        } else {
            //si l'autorisation de la fonction contient F c'est le SU {
            //2 = guichet, 3=magasin, 4 =technicien,5 ) admin
            $hexa_auth_visiteur_categorie = array('2', '3', '4', '5'); // on lu mets toutes le catégories
            $hexa_auth_visiteur_menu = array(
                '1', '10', '4F', '50', '52', '53', '54', '55', '56', '5E', '5F', '30','31','32'); // on met tout les sous menu
            $this->css_admin = '<link rel=stylesheet type="text/css" href="../public/css/admin.css">'; //css admin
        }
        //génération des liens catégories et sous catégorie en fonction des autorisations 
        $this->lien_categorie = startIndex::authCategorie($hexa_auth_visiteur_categorie);
        $this->lien_menu = startIndex::authMenu($hexa_auth_visiteur_menu, $context);
    }

    public function getLienCategorie() {
        return $this->lien_categorie;
    }

    public function getLienMenu() {
        return $this->lien_menu;
    }

    public function filtreMenu($menu,$menu_courant) {
        $menu_filtre = array();
        foreach ($menu as $M) {
            if (!preg_match("#".$menu_courant."#", $M['url'])) { 
                unset($M);// on supprime les menus qui n'appartienne pas à la page
            }
             else {
                $menu_filtre[] = $M;
            }
        }
        return $menu_filtre;
    }

    public static function authMenu($array_hexa_auth_visiteur, $context) {//lister les sous menus
        $visiteur = $_SESSION['visiteur'];

        if ($visiteur->getMenuConcerne() != NULL) {//si on demande un type su ou employé
            $type_membre = $visiteur->getMenuConcerne();
        }

        if ($context != NULL) {//supprimer l'action qui a le même nom que le lien
            $kill_index = array_search($context, $array_hexa_auth_visiteur);
            unset($array_hexa_auth_visiteur[$kill_index]);
        }

        foreach ($array_hexa_auth_visiteur as $H) {
            switch (hexdec($H)) {
                //sous menu receptionniste 
                case 16://10
                    $sous_menu[] = array('url' => '../client/ajouter_client.php', 'lien' => 'ajouter un client');
                    break;
                case 17://11
                    //$sous_menu[] = array('url' => '../client/lister_client.php?type=client', 'lien' => 'lister dernier client');
                    break;
                case 18://12
                    $sous_menu[] = array('url' => '../client/recherche_client.php', 'lien' => 'rechercher client');
                    break;

                case 19://13
                    if (isset($type_membre) && $type_membre == 'client') {
                        //$sous_menu[] = array('url' => '../app/fiche_membre.php?type=client', 'lien' => 'fiche client');
                    }
                    break;
                case 20://14
                    //$sous_menu[] = array('url' => '../app/editer_membre.php', 'lien' => 'editer un client');
                    break;

                /*
                  case 21://15
                  $sous_menu[] = array('url' => '../membre/modifier_client.php', 'lien' => 'modifier client');
                  break;
                 * 
                 */
                case 30://1E
                    $sous_menu[] = array('url' => '../membre/bannir_client.php', 'lien' => 'bannir client');
                    break;
                case 31://1F
                    $sous_menu[] = array('url' => '../membre/supprimer_client.php', 'lien' => 'supprimer client');
                    break;

                //
                /*
                  case 32://20
                  $sous_menu[] = array('url' => '../reception/ajouter_affaire.php', 'lien' => 'ajouter affaire');
                  break;
                  //
                  case 33://21
                  $sous_menu[] = array('url' => '../reception/lister_affaire.php', 'lien' => 'liste dernier affaire');
                  break;
                  /*
                  case 34://22
                  $sous_menu[] = array('url' => '../reception/rechercher_affaire.php', 'lien' => 'fiche affaire');
                  break;
                 * 

                  case 35://23
                  $sous_menu[] = array('url' => '../reception/detail_affaire.php', 'lien' => 'détail_affaire');
                  break;
                  /*
                  case 36://24
                  $sous_menu[] = array('url' => '../reception/editer_affaire.php', 'lien' => 'mode edtion affaire');
                  break;
                 * 

                  case 37://25
                  $sous_menu[] = array('url' => '../reception/modifier_affaire.php', 'lien' => 'modifier affaire');
                  break;
                  case 47://2F
                  $sous_menu[] = array('url' => '../reception/supprimer_affaire.php', 'lien' => 'supprimer affaire');
                  break;
                 * 
                 */

                //magasin
                case 48://30
                    $sous_menu[] = array('url' => '../magasin/ajouter_piece.php', 'lien' => 'ajouter pièce');
                    break;
                case 49://31
                    $sous_menu[] = array('url' => '../magasin/list_piece.php', 'lien' => 'liste piece');
                    break;
                case 50://32
                    $sous_menu[] = array('url' => '../magasin/rechercher_piece.php', 'lien' => 'recherche piece');
                    break;
                case 51://33
                    //  $sous_menu[] = array('url' => '../magasin/fiche_piece.php', 'lien' => 'fiche piece');
                    break;
                case 52://34
                   // $sous_menu[] = array('url' => '../magasin/editer_piece.php', 'lien' => 'mode edtion affaire');
                    break;
                case 53://35
                    //$sous_menu[] = array('url' => '../magasin/modifier_piece.php', 'lien' => 'modifier affaire');
                    break;
                case 54://36
                    //$sous_menu[] = array('url' => '../magasin/moins_quantite_piece.php', 'lien' => 'démagasiner quantité pièce');
                    break;
                case 55://37
                    //$sous_menu[] = array('url' => '../magasin/plus_quantite_piece.php', 'lien' => 'ajouter une quantié pièce');
                    break;
                case 63://3F
                    //$sous_menu[] = array('url' => '../magasin/suprimer_piece.php', 'lien' => 'supprimer la pièce');
                    break;
                //technicien
                /*
                  case 64://40
                  $sous_menu[] = array('url' => '../tecnique/ajouter_intervention.php', 'lien' => 'ajouter intervention');
                  break;
                 * 
                 */
                case 65://41

                    $sous_menu[] = array('url' => '../technique/tech_intervention.php?crypt=' . $visiteur->getCrypt(), 'lien' => 'mes fiches interventions');
                    break;
                /*
                  case 66://42
                  $sous_menu[] = array('url' => '../tecnique/rechercher_intervention.php', 'lien' => 'rechercher une tâche');
                  break;
                 * 

                  case 67://43
                  $sous_menu[] = array('url' => '../tecnique/detail_intervention.php', 'lien' => 'histoirique des tâche ');
                  break;

                  case 68://44
                  $sous_menu[] = array('url' => '../tecnique/editer_intervention.php', 'lien' => 'editer une tâche');
                  break;

                  case 69://45
                  $sous_menu[] = array('url' => '../tecnique/modifier_intervention.php', 'lien' => 'modifer une des tâches ');
                  break;
                 * 
                 */
                case 79://4F
                    //  $sous_menu[] = array('url' => '../tecnique/supprimer_intervention.php', 'lien' => 'supprimer une des tâches ');
                    break;

                // SU
                case 80://50
                    $sous_menu[] = array('url' => '../membre/ajouter_membre.php', 'lien' => 'ajouter un membre');
                case 81://51
                    $sous_menu[] = array('url' => '../membre/liste_membre.php', 'lien' => 'liste des membres');
                    break;
                case 82://52
                    $sous_menu[] = array('url' => '../membre/recherche_membre.php', 'lien' => 'recherche membre');
                    break;
                case 83://53
                    // $sous_menu[] = array('url' => '../membre/fiche_membre.php', 'lien' => 'fiche collaborateur');
                    break;

                case 84://54
                    //  $sous_menu[] = array('url' => '../membre/editer_employe', 'lien' => 'editer la fiche employé');
                    break;
                case 85://55
                    //    $sous_menu[] = array('url' => '../membre/modifier_employe.php', 'lien' => 'modifer un employe ');
                    break;
                case 94://5E
                    //   $sous_menu[] = array('url' => '../membre/bannir_employe.php', 'lien' => 'bannir un employe ');
                    break;

                case 95://5F
                    //  $sous_menu[] = array('url' => '../membre/supprimer_employe.php', 'lien' => 'supprimé employé');
                    break;
            }
        }
        return $sous_menu;
    }

    public function getErreur() {
        return $this->erreur;
    }

    static function authCategorie($hexa_auth_visiteur_filtrer) {//lister les liens autorisers
        $lien_categorie = array();

        foreach ($hexa_auth_visiteur_filtrer as $H) {

            switch (hexdec($H)) {//en hexa on permet de générer 16 categories
                case 1:
                    if ($_SESSION['visiteur']->getTypeUserVisiteur() == 'SU') { // seul le super utilisateur à le doit de d'avoir ce client
                        $lien_categorie[] = array('url' => '../membre/liste_membre.php?type=client', 'lien' => 'client');
                    } else {
                        $lien_categorie[] = array('url' => '../client/recherche_client.php', 'lien' => 'client');
                    }
                    break;
                case 2:
                    $lien_categorie[] = array('url' => '../client/recherche_client.php', 'lien' => 'réception');
                    break;
                case 3:
                    $lien_categorie[] = array('url' => '../magasin/list_piece.php', 'lien' => 'stock');
                    break;
                case 4:
                    $lien_categorie[] = array('url' => '../technique/index.php', 'lien' => 'Technique');
                    break;
                case 5:
                    $lien_categorie[] = array('url' => '../membre/liste_membre.php?type=collaborateur', 'lien' => 'collaborateur');
                    break;
            }
        }
        return $lien_categorie;
    }

}

// PROJET STEPHANE NGOV V1.14
?>
