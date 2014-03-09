<?php

class Form {

    protected $token_crypt;
    protected $form_date;
    protected $session_visiteur = NULL;
    protected $ajouter_modifier; //A= ajouter, M=modifier
    protected $submit = NULL;
    protected $cible_verif_saisie_recherche = "../app/verif_saisie_recherche.php";
    protected $type_use_forme_membre = NULL; //qui utilise le formulaire 
    protected $cible = NULL;
    protected $titre_form = NULL;
    protected $name = NULL;
    protected $modif = NULL;

    public function __construct($cible, $titre_form, $name) {
        $now = new DateTime();
        $this->form_date = $now->format('Y-m-d H:s');
        if (!isset($_SESSION['visiteur'])) {//première affichage de la page d'accueil ,création d'un visiteur mystère
            $this->genCrypt();
        } else {
            $visiteur = $_SESSION['visiteur'];
            $this->type_use_forme_membre = $visiteur->getTypeUserVisiteur();
            $visiteur->newJeton(); //on refrachit le jeton
            $this->token_crypt = $visiteur->getCrypt();
            $this->session_visiteur = $visiteur;
            if ($visiteur->getAjouterOrModifier() == 'M') { //si on est en mode modifié on crée sont champ hidde modifier
                $this->modif = TRUE;
            }
        }
        $this->cible = $cible;
        $this->titre_form = $titre_form;
        $this->name = $name;
        $this->openForm(); //début du formulaire
    }

    //on se sert d'un champs hidden pour que dire de modifer à la place d'ajouter
    public function doFormModifier() {
        ?>
        <input type="hidden" name="do_modifier">
        <?php
    }

    public function openForm() {
        if ($this->titre_form != 'connexion') {//si c'est le formulaire de connextion on affiche pas le titre
            ?>
            <h3><?php
                if ($this->titre_form != NULL) {
                    echo $this->titre_form .' :';
                }
            }
            ?></h3>
        <form <?php
        if ($this->titre_form != NULL) { //appelle mode edition appeller l'attribut css edition
            echo 'id=' . $this->name;
        } else {
            echo 'class=edition';
        }
        ?> method="POST" action="<?php echo $this->cible ?>">
                <?php
            }

            public function genCrypt() {//on génère un jeton pour la première connexion
                $visiteur = new Visiteur(); //création du visiteur création d'un jeton
                $this->token_crypt = $visiteur->getCrypt();
                $_SESSION['visiteur'] = $visiteur; //on garde la session du visiteur mystère
            }

            public function endForm($submit) {//terminer le formulaire
                if ($this->modif == TRUE) {
                    $this->doFormModifier();
                }
                ?> <input type="hidden" name="crypt" value="<?php echo $this->token_crypt ?>">
            <?php if ($submit != 'connexion') { ?><input  class="submit" type="submit" value="<?php echo $submit ?>"  >    
            <?php } else { ?> <input id="On" type="image" src="http://localhost/nfa/public/image/px/enter.png" name="submit">
            <?php }
            ?>
        </form>
        <?php
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
