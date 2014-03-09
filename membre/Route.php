<?php

require_once '../lib/Ini.php';

class Route {

    static function routage($get_id_page) {

        switch ($get_id_page) {
            //XXX page public
            case 0: //page redirection index.php
                header('Location: ../public/index.php');
                break;
            case 1://menu principal
                header('Location: ../app/index.php');
                break;
            //1XXX page client 
            case 1000:
                header('Location: ../client/index.php'); //rechercher un client
                break;
            case 1001:
                $id_client = $_SESSION['visiteur']->getMemNextAction();
                header('Location: ../client/fiche_client.php?id_client=' . $id_client . '&crypt=' . $_SESSION['visiteur']->getCrypt()); //rechercher un client
                break;
            case 1002:
                header('Location: ../client/ajouter_client.php'); //rechercher un client
                break;
            case 1005://rechercher un client
                header('Location: ../client/recherche_client.php');
                break;
            //2XXX page facture
            case 2000://creation facture
                $visiteur = $_SESSION['visiteur'];
                $id_facture = $visiteur->getMemNextAction(); //on récupérer l'id affaire
                header('Location: ../facture/voir_facture.php?id_facture=' . $id_facture);
                break;

            case 2001:

                break;
            //4XXX page receptionniste
            case 4000:
                header('Location: ../reception/ajouter_affaire.php');
                break;
            case 4001:
                header('Location: ../reception/index.php');
                break;
            case 4002:
                $visiteur = $_SESSION['visiteur'];
                $visiteur->clearInputForm(); //remise à zero les mode ajouter ou modifier
                header('Location: ../reception/fiche_affaire.php?id_affaire=' . $visiteur->getMemNextAction());
                break;
            //5XXX page magaziner
            case 5000:
                header('Location: ../magasin/ajouter_piece.php');
                break;
            case 5001:
                header('Location: ../magasin/rechercher_piece.php');
                break;
            case 5002:
                header('Location: ../magasin/fiche_piece.php');
                break;
            //6XXX page technicien
            case 6000:
                header('Location: ../technique/index.php');
                break;
            case 6001:
                header('Location: ../technique/ajouter_intervention.php');
                break;
            case 6002:
                header('Location: ../technique/fiche_intervention.php?id=' . $_POST['id_inter'] . '&crypt=' . $_POST['crypt'] . ' ');
                break;
            case 6003:
                header('Location: ../technique/cloture_inter.php');
                break;



            //6XXX pour les pages membre et admin
            case 7000:
                header('Location: ../membre/ajouter_membre.php');
                break;
            case 7001:
                header('Location: ../membre/fiche_membre.php');
                break;
            //cette route permet de de modifier le membre en utilisant ajouter_membre.php
            case 7002:
                $visiteur = $_SESSION['visiteur'];
                $visiteur->setModeModifier();
                header('Location: ../membre/ajouter_membre.php');
                break;
            case 7003:
                header('Location: ../membre/liste_membre.php');
                break;
            case 7004://suppression effective
                header('Location: ../membre/liste_membre.php?type=client');
                break;
            case 7005://suppression effective
                header('Location: ../membre/recherche_membre.php');
                break;
            //8XXX page erreur
            case 8000:
                header('Location: ../erreur/jeton_perime.php');
                break;
            case 8001:
                header('Location: ../erreur/interdire.php');
                break;
            case 8002:
                header('Location: ../erreur/echec_connexion.php');
                break;
            case 8003:
                header('Location: ../erreur/block_page.php');
                break;

            case 9999:// page forcer la modif du SU
                header('Location: ../membre/oubli_mdp.php');
                break;
            default :
                header('Location: ../erreur/404.php');
        }
    }

}

?>
