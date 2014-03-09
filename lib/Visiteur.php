<?php

require_once'../lib/Ini.php';

class Visiteur {

    //le sujet 
    private $type_user_concerne = NULL; //le type d'utlisateur concerné
    private $nom_membre_concerne = NULL; //récupération juste pour afficher le nom du client
    private $id_courrant = NULL; //prochaine action qui concernet l'id membre ou autre
    private $hexa_auth_visiteur = NULL;
    private $hexa_auth_concerne = NULL;
    private $collect_erreur = NULL; //récolte des erreur par le visiteur
    private $form_post = NULL;
    private $verif_selection = NULL;
    private $resulat_recherche = NULL;
    //si false =mode modif nouveau membre, true = mode membre existant
    private $verif_champ_mdp = NULL; //on vérifie le remplissage de ces 2 champs mdp
    //comment l'action doit se comporter
    private $ajouter_or_modifier = NULL; //A= ajouter, B= Modifier
    private $menu_concerne = NULL; //selon le contexte on affiche client employé
    private $flash_info = NULL;
    private $next_route = NULL; //la prochaine route
    //sécurité
    private $token;
    private $tentative = 5; //servi que lorsqu'on se connecte
    //le visiteur 
    private $id_visiteur = NULL; //id membre du visiteur
    private $type_user_visiteur = NULL; //le type de l'utilisateur du visiteur
    private $nom_visiteur = NULL;

    public function __construct() {
        $this->newJeton();
    }

    public function setTypeUserConcerne($type_user_concerne) {
        $this->type_user_concerne = $type_user_concerne;
    }

    public function getTypeUserConcerne() {
        return $this->type_user_concerne;
    }

    public function setNextRoute($route) {
        $this->next_route = $route;
    }

    public function getNextRoute() {
        return $this->next_route;
    }

    public function setResultFind($resultat) {
        $this->resulat_recherche = $resultat;
    }

    public function getResultFind() {
        return $this->resulat_recherche;
    }

    public function clearRecherche() {
        $this->resulat_recherche = NULL;
        $this->refreshVisiteur();
    }

    public function setFlashInfo($info) {//affichage d'un message retour
        $this->flash_info = $info;
    }

    public function getFlashInfo() {//affichage d'un message retour
        return $this->flash_info;
    }

    public function setNomMembreConcerne($nom_membre_concerne) {
        $this->nom_membre_concerne = $nom_membre_concerne;
    }

    public function getNomMembreConcerne() {
        return $this->nom_membre_concerne;
    }

    public function getMenuConcerne() { //client ou employé
        return $this->menu_concerne;
    }

    public function setMenuConcerne($concerne) { //client ou employé
        $this->menu_concerne = $concerne;
    }

    public function getIdVisiteur() {
        return $this->id_visiteur;
    }

    public function getTypeUserVisiteur() {//normalement retourne su ou reception
        return $this->type_user_visiteur;
    }

    public function InitialMod() {//on remet à zero les mode Ajouter ou modifier
        $this->ajouter_or_modifier = NULL;
        $this->verif_champ_mdp = NULL;
    }

    public function getAjouterOrModifier() {
        return $this->ajouter_or_modifier;
    }

    //méthode qui permet d'être en mode modif membre existant
    public function setModeModifier() {
        //on ne vérifie pas le champs mdp sauf si on les remplis
        $this->verif_champ_mdp = FALSE;
        $this->ajouter_or_modifier = "M"; //on désactive en même temps la modification du mdp
    }

    //méthode qui permet d'être en mode modif membre existant
    public function setModeAjouter() {
        $this->verif_champ_mdp = TRUE;
        $this->ajouter_or_modifier = "A"; //on désactive en même temps la modification du mdp
    }

    //true = on vérifie le champs mdp, false on ne vérifie pas
    public function setVerifChampMdp($verif_champ) {
        $this->verif_champ_mdp = $verif_champ;
    }

    public function getVerifChampMdp() {//oui on nom on vérfie le champs mdp 
        return $this->verif_champ_mdp;
    }

    public function setMemNextAction($id_courrant) {//id_client ou id_affaire ...
        $this->id_courrant = $id_courrant;
    }

    public function getMemNextAction() {//id_client ou id_affaire ...
        return $this->id_courrant;
    }

    //*******************HYDRATATION FORMULAIRE ET RECUPERATION DU POST********************

    public function setInputForm($input_form) {//sauvegarde des objets qui permet de préremplire les formulaires 
        $this->form_post = $input_form;
        $this->refreshVisiteur();
    }

    public function setHexaAutConcerne($hexa_auth_membre) {
        $this->hexa_auth_concerne = $hexa_auth_membre;
        $this->refreshVisiteur();
    }

    public function getInputForm() {//récupère les saisies du formulaire
        return $this->form_post;
    }

    public function getInputHexaMembreConcerne() {
        return $this->hexa_auth_concerne;
    }

    public function setSelectionOk($selection_ok) {
        $this->verif_selection = $selection_ok;
    }

    public function getSelectionOk() {
        return $this->verif_selection;
    }

    public function allAtributVisiteur() {//récupérer tout les attributs
        return get_object_vars($this);
    }

    //forcer l'autorisation
    public function setHexaAuthVisiteur($hexa_auth_visiteur) {
        $this->hexa_auth_visiteur = $hexa_auth_visiteur;
    }

    public function getHexaAuthVisiteur() {
        return $this->hexa_auth_visiteur;
    }

    public function refreshVisiteur() {
        $_SESSION['visiteur'] = $this;
    }

    public function setErreur($collect_erreur) {
        $this->collect_erreur = $collect_erreur;
    }

    public function getCollectErr() {
        return $this->collect_erreur;
    }

    public function getErreur() {
        $nb_erreur = count($this->collect_erreur);
        if ($nb_erreur > 0) {
            echo '<span class="erreur">';
            foreach ($this->collect_erreur as $C) {
                echo $C . "<br/>";
            }
            echo '</span>';
            //on vide l'erreuir en cas de changement de page
            $this->collect_erreur = NULL;
        }
    }

    public function getToken() {
        return $this->token;
    }

    public function getCrypt() {
        return $this->token['crypt'];
    }

    public function getNomVisiteur() {
        return $this->nom_visiteur;
    }

    public function clearInputForm() {//nettoyage des erreurs et des saisies
        $this->form_post = NULL; //vider le champs préremplit
        $this->hexa_auth_concerne = NULL; //vide les autorisations coché
        $this->collect_erreur = NULL;
        $this->refreshVisiteur(); //met à jour la session
    }

    public function clearResultat() {
        $this->resulat_recherche = NULL;
    }

    public function clearFlashInfo() {
        $this->flash_info = NULL;
    }

    public function newJeton() {
        $token = new Jeton();
        $this->token = $token->getToken();
        $this->refreshVisiteur();
    }

    //on charge les informations du nouveau visiteur
    public function setVisiteur($id_visiteur, $nom_visiteur, $hexa_auth_visiteur, $type_user_visiteur) {
        $this->id_visiteur = $id_visiteur;
        $this->nom_visiteur = $nom_visiteur;
        $this->hexa_auth_visiteur = $hexa_auth_visiteur;
        $this->type_user_visiteur = $type_user_visiteur;
    }

    public function moinsTentative() {
        $this->tentative = $this->tentative - 1;
        if ($this->tentative < 0) {
            Route::routage(8000);
        }
    }

    public function getResteTentative() {
        return $this->tentative;
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
