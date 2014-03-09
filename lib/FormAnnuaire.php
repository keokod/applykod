<?php
require_once '../lib/Ini.php';

class FormAnnuaire extends Form {//cette class affiche le formulaire de l' 

    private $err_form = NULL;
    protected $cible;
    protected $id_membre = NULL; //numéro du membre si on modifie le membre
    protected $email = NULL;
    protected $invitation; //modifier,ajouter ...
    private $suspendu;
    private $mdp = NULL;
    private $civilite = NULL;
    protected $nom = NULL;
    protected $prenom = NULL;
    protected $adresse = NULL;
    protected $telephone = NULL;
    private $permission; //les permissions pour chaque action selon le context sous forme 1,2,3 ...
//1 = voir, 2= editer, 3 = supprimer
    private $disabled = NULL; //pour désacrier le champs civilité dans le cas d'une modification de profil
    private $role = NULL; // 0: super utilisateur, 1:client, 2:receptionniste, 3:technicien
//Affichage Titre et l'action 
// private $action = NULL; //nom du fichier à dirigé du formulaire
    private $form_info; //titre du formulaire
    private $select_monsieur = NULL; //si selected premet de savoir lequel on a sélectionner 
    protected $select_madame = NULL;
    protected $select_mademoiselle = NULL;
    private $select_SU = NULL; // Le Super Utilisation 
    private $select_technique = NULL; //le technicien
    private $select_magasin = NULL; //le magasinier
    private $select_reception = NULL; //receptionniste
    private $select_client = NULL; //le client
    private $desactiver_civilite = NULL;
    private $desactiver_fonction = NULL;
    private $confirm_pass = TRUE;
    protected $token_crypt = NULL; //jeton de sécurité
    private $box_receptione = NULL;
    private $box_affaire = NULL;
    private $box_magasin = NULL;
    private $box_technique = NULL;
//cheekbox client
    private $x_add_membre = NULL; //pour cocher le cheekbox= checked pour cocher
    private $x_list_membre = NULL; //pour cocher le cheekbox
    private $x_find_membre = NULL; //pour cocher le cheekbox
    private $x_fiche_membre = NULL; //pour cocher le cheekbox
    private $x_edit_membre = NULL;
    private $x_modif_membre = NULL; //pour cocher le cheekbox
//cheekbox reception
    private $x_add_affaire = NULL; //pour cocher le cheekbox
    private $x_list_affaire = NULL; //pour cocher le cheekbox
    private $x_find_affaire = NULL; //pour cocher le cheekbox
    private $x_fiche_affaire = NULL; //pour cocher le cheekbox
    private $x_edit_affaire = NULL; //pour cocher le cheekbox
    private $x_modif_affaire = NULL; //pour cocher le cheekbox
//magasin
    private $x_add_piece = NULL; //pour cocher le cheekbox
    private $x_list_piece = NULL; //pour cocher le cheekbox
    private $x_find_piece = NULL; //pour cocher le cheekbox
    private $x_fiche_piece = NULL; //pour cocher le cheekbox
    private $x_edit_piece = NULL; //pour cocher le cheekbox
    private $x_modif_piece = NULL; //pour cocher le cheekbox
    private $x_moins_piece = NULL; //pour cocher le cheekbox
    private $x_plus_piece = NULL; //pour cocher le cheekbox
    private $x_kill_piece = NULL; //pour cocher le cheekbox
//technicien
    private $x_add_inter = NULL; //pour cocher le cheekbox
    private $x_list_inter = NULL; //pour cocher le cheekbox
    private $x_find_inter = NULL; //pour cocher le cheekbox
    private $x_fiche_inter = NULL; //pour cocher le cheekbox
    private $x_edit_inter = NULL; //pour cocher le cheekbox
    private $x_modif_inter = NULL; //pour cocher le cheekbox
    private $x_kill_inter = NULL; //pour cocher le cheekbox
    private $info_mdp = NULL;

    public function __construct($cible, $titre_form, $name) {
        parent::__construct($cible, $titre_form, $name);
    }

    public function formLoggin() {//forumaire pour se connecter
        ?>
        <form id="identifiant" method="POST" action="../app/verif_saisie_connexion.php">
            <img class="identifiant" src="../public/image/px/user.png">
            <input id="email_go"  type="texte" name="email" size="10" value="<?php echo $this->email ?>" placeholder="email">
 
            <img class="identifiant" src="../public/image/px/key.png"> 
            <input id="valid_min" type="password" name="mdp" size="8" onfocus="this.value=''" >
            <!-- valid min pour appeller revenir au focus -->
            <?php
        }

        public function hydrateModifierMembre($id_membre) {//récupération de l'id membre à modifier
            //cherche tout seul le membre
            $trouve_membre = new Membre();
            $trouve_membre->hydrateMembre($id_membre);
            $extract_data_membre = $trouve_membre->allAtributMembre();
            $this->hydrateFormMembre($extract_data_membre, $extract_data_membre['hexa_auth']);
        }

        //hydrater les attribut du membre email,civilite,nom,prenom,adresse,telephone
        public function hydrateFormMembre($poster, $hexa_auth_membre) {// pour modifier ou echec formulaire
            $this->id_membre = $poster['id_membre'];
            $this->civilite = $poster['civilite'];
            $this->nom = $poster['nom'];
            $this->prenom = $poster['prenom'];
            $this->adresse = $poster['adresse'];
            $this->telephone = $poster['telephone'];
            $this->email = $poster['email'];


            switch ($poster['civilite']) {//on pré selection l'option du membre en fonction de sa civilté
                case 1:
                    $this->select_monsieur = 'selected';
                    break;
                case 2:
                    $this->select_madame = 'selected';
                    break;
                case 3:
                    $this->select_madame = 'selected';
                    break;
                /*
                  default :
                  $this->desactiver_civilite = 'disabled'; //si on trouve pas la civité on désactive l'option
                 * */
            }
            if ($hexa_auth_membre != NULL) {//si on a coché des autorisations on 
                $this->hydrate_coche($hexa_auth_membre);
            }
            

            if($this->session_visiteur->getTypeUserVisiteur() =='reception') // si on est connecté sous un receptionniste on enregistre obligatoirement un client
            {
                $poster['type_user'] = 'client';
            }
            
            $this->selectTypeUser($poster['type_user']);
        }

        public function selectTypeUser($type_user) {//on selectionne le type du membre
            
            if ($type_user == 'client') {
                $this->select_client = 'selected';
            }
            if ($type_user == 'reception') {
                $this->select_reception = 'selected';
            }
            if ($type_user == 'magasin') {
                echo "<h1>magasin</h1>";
                $this->select_magasin = 'selected';
            }
            if ($type_user == 'technique') {
                $this->select_technique = 'selected';
            }
        }

        public function formEmailMdp() {//juste l'email et mot de passe pour se connecter
            $this->formEmail();
            ?>
            <label>mot de passe</label>
            <input type="password" name="mdp"><br/>
            <?php
        }

        public function formEmail() {
            ?>
            <label>courriel (utiliser comme login):</label>
            <input type="texte" name="email" value="<?php echo $this->email ?>"><br>
            <?php
        }

        public function autreFormEmailMdp() {//juste l'email et mot de passe
            ?>
            <label>courriel</label>
            <input type="texte" name="email" value="<?php echo $this->email ?>"><br>
            <label>mot de passe</label>
            <?php
            if ($this->info_mdp != NULL) {// si =! NULL en mode modif existant
                ?>
                Pour modifier votre mot de passe,
                mettez le et confirmez.<br/>
                Sinon laisser ces champs vide<br/>

                <?php
            }
            ?>
            <input type="password" name="mdp"><br/>
            <?php if ($this->confirm_pass === TRUE) {//si pas de session, formulaire de connexion identifiant
                ?>
                <label>confirmer votre mot de passe</label>
                <input type="password" name="confirm_mdp"><br/>
                <?php
            }
//affiche la fin du formulaire uniquement si c'est pour se connecter 
        }

        public function getFormModifierMembre() {//nom de methode juste pour la compréhension que c'est pour modifier
            $this->getFormAjouterMembre();
        }

        public function FormAjouterMembre() { //action = ajouter membre ou modifier membre
//on met l'email en premier pour vérifier son l'unicité
            $this->getFormIdentifiant();
            $this->getSimpleFormMembre();
        }

        public function formSimpleFormMembre() {//pour les clients par exempmle sans mdp
            $this->formEmail();
            ?>
                
            <input type="hidden" name="id_membre" value="<?php echo $this->id_membre ?>">
            <label>civilité :</label>

            <select name="civilite">
                <option value="1" <?php echo $this->select_monsieur ?>>Monsieur</option>
                <option value="2" <?php echo $this->select_madame ?> >Madame</option>
                <option value="3" <?php echo $this->select_mademoiselle ?>> Mademoiselle</option>
            </select><br/>

            <label>nom :</label>
            <input type="texte" name="nom" value="<?php echo $this->nom ?>" ><br/>

            <label>prenom :</label>
            <input type="texte" name="prenom" value="<?php echo $this->prenom ?>"><br/>

            <label>adresse :</label>
            <textarea name="adresse" ><?php echo $this->adresse ?></textarea>

            <label>telephone </label>
            <input type="texte" name="telephone" value="<?php echo $this->telephone ?>"><br/>
            <?php
        }

        public function formEmailValidMdp() { //email + mdp + verif mdp
            $this->formEmailMdp();
            ?>
            <label>valider votre mot de passe</label>
            <input type="password" name="confirm_mdp"><br/>  
            <?php
        }

        public function fixFormAuth($hexa_auth) { //pas de choix possible pour cette méthode
            ?>
            <input type="hidden" name="hexa_auth" value= "' . $hexa_auth . '"  ><br/>
            <?php
        }

        public function choixFormRole() { //choix possible du role pour le SU
            ?>
            <label>role du membre :</label>
            <SELECT name="type_user">
                <!-- <OPTION VALUE="client" <?php echo $this->select_client ?>>client</OPTION> -->
                <OPTION VALUE="reception" <?php echo $this->select_reception ?>>reception</OPTION>
                <OPTION VALUE="magasin" <?php echo $this->select_magasin ?> >magasin</OPTION>
                <OPTION VALUE="technique" <?php echo $this->select_technique ?>>technique</OPTION>
            </SELECT>
            <?php
        }

        public function fixFormRoleClient() { //impose que le nouveau membre sera un client
            $visiteur = $_SESSION['visiteur'];
            $type_user = $visiteur->getTypeUserVisiteur();
            if ($type_user == 'SU') {//on choisi le type seulement pour l'administrateur
                ?> :
                <label>type du membre :</label>
                <SELECT name="type_user">
                    <OPTION VALUE="client" selected>client</OPTION>
                </SELECT>
            <?php
        }
    }

    public function setConfirmPass($confirmer) {//faire appraître le champs confirmation mot de passe
        $this->confirm_pass = $confirmer;
    }

    public function authCaseCocher($titre_chk_box, $id_chk_box) {//pour hydrater
            $this->caseChocher(); //on récupère les input cheekbox;
            ?>
                <h3><?php echo $titre_chk_box ?></h3>
                <hr class="deco_auth"/>
                <?php
                switch ($id_chk_box) {
                    case 0:
                        $name_chk_box = $this->box_receptione;
                        break;
                    case 1:
                        $name_chk_box = $this->box_affaire;
                        break;
                    case 2:
                        $name_chk_box = $this->box_magasin;
                        break;
                    case 3:
                        $name_chk_box = $this->box_technique;
                        break;
                }

                foreach ($name_chk_box as $INPUT) {
                    ?>
                    <span class="chk_auth">
                        <input type="checkbox" name="<?php echo $INPUT['name'] ?>" value="<?php echo $INPUT['value'] ?>"  <?php echo $INPUT['cocher'] ?> ><?php echo $INPUT['show'] ?>
                    </span>
            <?php
        }
        echo "<div>";
    }

    public function caseChocher() {

        $this->box_receptione = array(
            //client
            array('name' => 'add_membre', 'value' => '10', 'show' => 'ajouter un client ', 'cocher' => $this->x_add_membre),
            array('name' => 'list_membre', 'value' => '11', 'show' => 'lister les membres (par date)', 'cocher' => $this->x_list_membre),
            array('name' => 'find_membre', 'value' => '12', 'show' => 'rechercher un membre', 'cocher' => $this->x_find_membre),
            array('name' => 'fiche_membre', 'value' => '13', 'show' => 'fiche membre ', 'cocher' => $this->x_fiche_membre),
            array('name' => 'edit_membre', 'value' => '14', 'show' => 'editer fiche client', 'cocher' => $this->x_edit_membre),
            array('name' => 'modif_membre', 'value' => '15', 'show' => 'modifier fiche membre ', 'cocher' => $this->x_modif_membre)
        );

        $this->box_affaire = array(
            //affaire 
            array('name' => 'add_affaire', 'value' => '20', 'show' => 'ajouter une affaire', 'cocher' => $this->x_add_affaire),
            array('name' => 'list_affaire', 'value' => '21', 'show' => 'lister les affaires (par date)', 'cocher' => $this->x_list_affaire),
            array('name' => 'find_affaire', 'value' => '22', 'show' => 'rechercher une affaire', 'cocher' => $this->x_find_affaire),
            array('name' => 'fiche_affaire', 'value' => '23', 'show' => 'détail de affaire', 'cocher' => $this->x_fiche_affaire),
            array('name' => 'edit_affaire', 'value' => '24', 'show' => 'mode edtion affaire', 'cocher' => $this->x_edit_affaire),
            array('name' => 'modif_affaire', 'value' => '25', 'show' => 'modifier fiche affaire', 'cocher' => $this->x_modif_affaire),
        );
        $this->box_magasin = array(
            array('name' => 'add_piece', 'value' => '30', 'show' => 'permettre d\'ajouter une pièce', 'cocher' => $this->x_add_piece),
            array('name' => 'list_piece', 'value' => '31', 'show' => 'ranger liste pièce (par date)', 'cocher' => $this->x_list_piece),
            array('name' => 'find_piece', 'value' => '32', 'show' => 'rechercher une pièce', 'cocher' => $this->x_find_piece),
            array('name' => 'fiche_piece', 'value' => '33', 'show' => 'fiche de la pièce', 'cocher' => $this->x_fiche_piece),
            array('name' => 'edit_piece', 'value' => '34', 'show' => 'mode endition piece', 'cocher' => $this->x_edit_piece),
            array('name' => 'modif_piece', 'value' => '35', 'show' => 'modifier la pièce', 'cocher' => $this->x_modif_piece),
            array('name' => 'moins_piece', 'value' => '36', 'show' => 'retire quantité pièce du stocke', 'cocher' => $this->x_moins_piece),
            array('name' => 'plus_piece', 'value' => '37', 'show' => 'ajouter quantité piece du stock', 'cocher' => $this->x_plus_piece),
            array('name' => 'kill_piece', 'value' => '3F', 'show' => 'supprimer référence pièce du stocke', 'cocher' => $this->x_kill_piece),
        );


        $this->box_technique = array(
            array('name' => 'add_inter', 'value' => '40', 'show' => 'ajouter une intervention ', 'cocher' => $this->x_add_inter),
            array('name' => 'list_inter', 'value' => '41', 'show' => 'liste intervention (par date)', 'cocher' => $this->x_list_inter),
            array('name' => 'find_inter', 'value' => '42', 'show' => 'trouve intervention', 'cocher' => $this->x_find_inter),
            array('name' => 'fiche_inter', 'value' => '43', 'show' => 'fiche intervenstion', 'cocher' => $this->x_fiche_inter),
            array('name' => 'edit_inter', 'value' => '44', 'show' => 'edit intervention', 'cocher' => $this->x_edit_inter),
            array('name' => 'modif_inter', 'value' => '45', 'show' => 'modif intervention', 'cocher' => $this->x_modif_inter),
            array('name' => 'kill_inter', 'value' => '4F', 'show' => 'supprimer intervention', 'cocher' => $this->x_kill_inter),
        );
    }

    public function hydrate_coche($array_hexa_auth) {

        foreach ($array_hexa_auth as $H) {

            switch (hexdec($H)) {
                //sous menu receptionniste 
                case 16://10
                    $this->x_add_membre = 'checked';
                    break;
                case 17://11
                    $this->x_list_membre = 'checked';
                    break;
                case 18://12
                    $this->x_find_membre = 'checked';
                    break;
                case 19://13
                    $this->x_fiche_membre = 'checked';
                    break;
                case 20://14
                    $this->x_edit_membre = 'checked';
                    break;
                case 21://15
                    $this->x_modif_membre = 'checked';
                    break;

                case 32://20
                    $this->x_add_affaire = 'checked';
                    break;
                case 33://21
                    $this->x_list_affaire = 'checked';
                    break;
                case 34://22
                    $this->x_find_affaire = 'checked';
                    break;
                case 35://23
                    $this->x_fiche_affaire = 'checked';
                    break;
                case 36://24
                    $this->x_edit_affaire = 'checked';
                    break;
                case 37://25
                    $this->x_modif_affaire = 'checked';
                    break;

                case 48://30
                    $this->x_add_piece = 'checked';
                    break;
                case 49://31
                    $this->x_list_piece = 'checked';
                    break;
                case 50://32
                    $this->x_find_piece = 'checked';
                    break;
                case 51://33
                    $this->x_fiche_piece = 'checked';
                    break;
                case 52://34
                    $this->x_edit_piece = 'checked';
                    break;

                case 53://35
                    $this->x_modif_piece = 'checked';
                    break;
                case 54://36
                    $this->x_moins_piece = 'checked';
                    break;
                case 55://37
                    $this->x_plus_piece = 'checked';
                    break;
                case 63://3F
                    $this->x_kill_piece = 'checked';
                    break;
                //technicien
                case 64://40
                    $this->x_add_inter = 'checked';
                    break;
                case 65://41
                    $this->x_list_inter = 'checked';
                    break;
                case 66://42
                    $this->x_find_inter = 'checked';
                    break;
                case 67://43
                    $this->x_fiche_inter = 'checked';
                    break;
                case 68://44
                    $this->x_edit_inter = 'checked';
                    break;
                case 69://45
                    $this->x_modif_inter = 'checked';
                    break;
                case 79://4F
                    $this->x_kill_inter = 'checked';
                    break;
            }
        }
    }

    public function formEmployer() {
        $this->formSimpleFormMembre();
        $this->choixFormRole();
        ?>
                    <div class="check_auth">
                        <?php
        $this->authCaseCocher('autorisation reception', 0); //0 = premier affichage
        $this->authCaseCocher('autorisation affaire', 1); //1 deuxième affichage..
        $this->authCaseCocher('autorisation magasin', 2);
        $this->authCaseCocher('autorisation technique', 3);
    }

    public function formClient() {

        $this->formSimpleFormMembre();
        $this->fixFormRoleClient();
    }

}

/*PROJET STEPHANE NGOV V1.38**/
?>
