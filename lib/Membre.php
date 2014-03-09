<?php

require_once '../lib/Ini.php';

class Membre {//classe qui permet d'enregister les infos de chaque membres

    protected $bdd;
    protected $id_membre = NULL; //permet de rechercher les relions en fonction des tables
    protected $email;
    protected $mdp; //mdp crypté
    protected $civilite;
    protected $nom;
    protected $prenom;
    protected $telephone;
    protected $adresse;
    protected $suspendu;
    protected $hexa_auth = NULL; //hexa_auth ne change pas quelque soit la page ou l'action souhaité
    protected $type_user = NULL;
    protected $session_visiteur = NULL;

    //le constructeur vérifie toujour si le token existe
    public function __construct() {//on vérifi la session du membre
        $this->bdd = Bdd::getIntance();
        if (isset($_SESSION['visiteur'])) {
            $this->session_visiteur = $_SESSION['visiteur'];
        }
    }

    public function dernierMembre() {//le dernier membre enregistré
        $query = "SELECT * FROM membre WHERE type_user='client'
                ORDER BY id DESC LIMIT 0,10";

        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function listeMembre($type) {

        if ($type == 'collaborateur') {
            $query = "SELECT * FROM membre WHERE type_user != 'client'  ORDER BY id ASC LIMIT 0,10 ";
        } else {
            $query = "SELECT * FROM membre WHERE type_user = 'client' ORDER BY id ASC LIMIT 0, 10";
        }
        $qb = $this->bdd->query($query);
        $recup_membre = $qb->fetchAll(PDO::FETCH_OBJ);
        return $recup_membre;
    }

    public function setAuthFonction($fonction) {
        $this->context_f = $fonction;
    }

    public function setTypeUser($type_user) {
        $this->type_user = $type_user;
    }

    public function allAtribut() {//récupérer tout les attributs
        return get_object_vars($this);
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function getToken() {
        return $this->token;
    }

    public function isMembreExist($email, $mdp, $crypt) {//vérifi s'il existe
        $mdp = sha1('nfa' . $mdp);
        $this->email = $email;
        $this->mdp = $mdp;
        $query = 'SELECT id,email,type_user FROM membre WHERE mdp=:mdp'; //echo $query;
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':mdp', $this->mdp, PDO::PARAM_STR);
        $verif = new VerifToken($crypt); //valide jeton ? si pas bon directon erreur
        $prep->execute();
        $recup_membre = $prep->fetch(); //si le couple correspond , il faut forcer la modification du profil SU
        if ($recup_membre['email'] == $email) {
            $this->id_membre = $recup_membre['id'];
            $this->type_user = $recup_membre['type_user'];
            $this->hydrateMembre($this->id_membre);
            //on récupère ses autorisatons
            $recup_auth = new Autorise();
            $this->hexa_auth = $recup_auth->getAuthBdd($this->id_membre);
        }
    }

    public function hydrateMembre($id_membre) {
        $query = "SELECT M.*,H.*
        FROM membre M
        LEFT JOIN auth_membre H
        ON M.id = H.id_membre
        WHERE M.id =:id_membre ";

        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
        $prep->execute();
        
        $membre = $prep->fetchAll(PDO::FETCH_OBJ);

        if ($membre != NULL) {//si le membre existe
            $recup_membre = $membre[0]; // ! sans autorisation = simple variable , plusieur aurisation  = table
            $this->id_membre = $recup_membre->id;
            $this->email = $recup_membre->email;
            $this->mdp = NULL; //on n'a pas besoin d'hydrater le mdp
            $this->civilite = $recup_membre->civilite;
            $this->nom = $recup_membre->nom;
            $this->prenom = $recup_membre->prenom;
            $this->telephone = $recup_membre->telephone;
            $this->adresse = $recup_membre->adresse;
            $this->suspendu = $recup_membre->suspendu;
            $this->type_user = $recup_membre->type_user;
        }

        $recup_hexa = array();
        foreach ($membre as $H) {
            $recup_hexa[] = $H->hexa_auth; //!hexa_auth champs hexa_auth obj
        }

        $this->hexa_auth = $recup_hexa; //récupération des autorisation
    }

    /*

      public function hydrateAuth($hexa_auth) {//!table hexa_auth
      $this->hexa_auth = $hexa_auth;
      }
     * 
     */

    public function allAtributMembre() {//récupérer tout les attributs
        return get_object_vars($this);
    }

    //méthode qui permet de charcher les attributs pour sa modification, pour éviter de retaper les champs post
    public function hydratModifMembre($post) {//on hydrate à partir d'un post
        extract($post);
        $this->email = $email;
        $this->civilite = $civilite;
        $this->nom = $nom;
        $this->mdp = sha1('nfa' . $mdp);
        $this->prenom = $prenom;
        $this->telephone = $telephone;
        $this->adresse = $adresse;
        $this->type_user = $type_user;
    }

    public function getIdMembre() {
        return $this->id_membre;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCivilite() {
        return $this->civilite;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getAdresse() {
        return $this->adresse;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getHexaAuth() {
        return $this->hexa_auth;
    }

    //normlement on utilise cette méthode pour modifier le membre SU
    public function setHexaAuth($hexa_auth) {
        $this->hexa_auth = $hexa_auth;
    }

    public function getTypeUser() {
        return $this->type_user;
    }

    public static function setMdpClient($email) {
        $long_chaine = sha1($email . time());
        $mdp_provistoire = substr($long_chaine, -8);
        return $mdp_provistoire;
    }

    public function isEmailExist($email, $id_membre) {
        $query = "SELECT id,email FROM membre WHERE email =:email";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':email', $email, PDO::PARAM_STR);
        $prep->execute();
        $data = $prep->fetch();
        if (!empty($data)) {
            if ($data['id'] == $id_membre) { //SI LE MAIL EST IDENTIQUE A CELUI QU ON VA METTRE A JOUR ALORS CELA NE SERA PAS UN 
                return FALSE;
            } else {
                return TRUE;// on retourn true si on tente d'enregistrer un autre email identique
            }
        } else {
            return FALSE;
        }
    }

}