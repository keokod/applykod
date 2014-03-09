<?php

require_once 'Ini.php';

class Inscription {

    protected $bdd;
    protected $session_crypt = NULL; //le jeton par post
    private $hexa_auth_visiteur = NULL; //on stock la table des autorisation
    private $id_membre;
    private $session_visiteur = NULL;
    private $auth_inscription = NULL;
    protected $nex_route = NULL;

    public function __construct() {//on récupère la session pour le jeton
        $this->bdd = Bdd::getIntance();
        $this->session_visiteur = $_SESSION['visiteur'];
        $this->nex_route = $this->session_visiteur->getNextRoute(); //prochaine route
        $this->session_crypt = $_SESSION['visiteur']->getCrypt();
        $this->hexa_auth_visiteur = $_SESSION['visiteur']->getHexaAuthVisiteur();
        foreach ($this->hexa_auth_visiteur as $H) {//seul le Su et le receptionniste à le droit d'inscire le membre
            if ($H == 'FF' || $H == '10') {
                $this->auth_inscription = TRUE; //on peut inscire
            }
        }
        if ($this->auth_inscription === NULL) {
            Route::routage(8000); //erreur!
        }
    }

    public function inscrireMembre($input_form, $hexa_auth_membre) {//enregistrement du membre (séparé pas de auth)
        $query = "INSERT INTO 
            membre(email,mdp,civilite,nom,prenom,telephone,adresse,suspendu,type_user)
            VALUES(:email,:mdp,:civilite,:nom,:prenom,:telephone, :adresse, :suspendu,:type_user)";
        $qb = $this->bdd->prepare($query);
        $qb->bindValue(':email', $input_form['email'], PDO::PARAM_STR);
        
        //génération d'un mot de passe aléatoire
        $mdp = new Mdp();
        $pif_mdp = $mdp->getNewMdp();
        $qb->bindValue(':mdp', sha1("nfa".$pif_mdp), PDO::PARAM_STR);//on met à 0 le mot de passe
        
        $qb->bindValue(':civilite', $input_form['civilite'], PDO::PARAM_INT);
        $qb->bindValue(':nom', $input_form['nom'], PDO::PARAM_STR);
        $qb->bindValue(':prenom', $input_form['prenom'], PDO::PARAM_STR);
        $qb->bindValue(':telephone', $input_form['telephone'], PDO::PARAM_INT);
        $qb->bindValue(':adresse', $input_form['adresse'], PDO::PARAM_STR);
        $qb->bindValue(':suspendu', 0, PDO::PARAM_INT); //0 ou 1
        
                    if($this->session_visiteur->getTypeUserVisiteur() =='reception') // si on est connecté sous un receptionniste on enregistre obligatoirement un client
            {
                 $input_form['type_user'] = 'client';
            }
            
            
        $qb->bindValue(':type_user', $input_form['type_user'], PDO::PARAM_STR); //SU,client,technicien,magasinier,receptionnste
        //on vérifie le jeton
        $verif_token = new VerifToken($input_form['crypt']); //si jeton pas bon page erreur

        $qb->execute();
        $id_membre = $this->bdd->lastInsertId();
        if ($hexa_auth_membre != NULL) {//si il possède des autorisation on l'enregistre dans la bdd
            $this->setHexaAuth($id_membre, $hexa_auth_membre);
        }
        $this->session_visiteur->setMemNextAction($id_membre); //on garde le membre fraichement enregistrer
        //si c'est un enregistrement d'un client on crée un mot de passe et envoie un mail


            $this->session_visiteur->setResultFind(array($_POST));
           $mdp->envoyMdp($input_form['email'], $input_form['nom'], $input_form['prenom']);

        
        Route::routage($this->nex_route); //7001 pour voir la fiche du membre en tant su
    }

    public function updateMdp($new_mdp,$id_membre)
    {
        $query="UPDATE membre SET mdp=:new_mdp WHERE id=:id_membre";
        $prepare = $this->bdd->prepare($query);
        $prepare->bindValue('new_mdp',$new_mdp,  PDO::PARAM_STR);
        $prepare->bindValue('id_membre',$id_membre,  PDO::PARAM_INT);
        $prepare->execute();
    }
    public function modifClient($input_modif) { //$verif_mdp TRUE = VERIFIER
        $this->id_membre = $this->session_visiteur->getMemNextAction(); //on récupère le numéro du membre à modifier
        $query = "UPDATE membre SET
            email=:email, civilite=:civilite,
            nom=:nom, prenom=:prenom, telephone=:telephone,
             adresse=:adresse, suspendu=:suspendu, type_user=:type_user
              WHERE id=:id_membre";
        $qb = $this->bdd->prepare($query);
        $qb->bindValue(':email', $input_modif['email'], PDO::PARAM_STR);
        $qb->bindValue(':civilite', $input_modif['civilite'], PDO::PARAM_INT);
        $qb->bindValue(':nom', $input_modif['nom'], PDO::PARAM_STR);
        $qb->bindValue(':prenom', $input_modif['prenom'], PDO::PARAM_STR);
        $qb->bindValue(':telephone', $input_modif['telephone'], PDO::PARAM_INT);
        $qb->bindValue(':adresse', $input_modif['adresse'], PDO::PARAM_STR);
        $qb->bindValue(':suspendu', 0, PDO::PARAM_INT); //0 ou 1
        $qb->bindValue(':type_user', $input_modif['type_user'], PDO::PARAM_STR); //SU,client,technicien,magasinier,receptionnste
        $qb->bindValue(':id_membre', $this->id_membre, PDO::PARAM_INT);
        $verif_token = new VerifToken($input_modif['crypt']);
        $qb->execute(); //si patte blanche, on execute la requête
        Route::routage(1001); //voir fiche membre modifier
    }

    public function modifMembre($input_modif, $modif_hexa_auth, $verif_mdp) { //$verif_mdp TRUE = VERIFIER
        $this->id_membre = $this->session_visiteur->getMemNextAction(); //on récupère le numéro du membre à modifier
        if ($verif_mdp === TRUE) {//si on souhaite modifier le mdp on rajoute le champs
            $champ_mdp = "mdp=:mdp ,";
        } else {//sinon on met rien
            $champ_mdp = NULL;
        }
        $query = "UPDATE membre SET
            email=:email," . $champ_mdp . "civilite=:civilite,
            nom=:nom, prenom=:prenom, telephone=:telephone,
             adresse=:adresse, suspendu=:suspendu, type_user=:type_user
              WHERE id=:id_membre";
        $qb = $this->bdd->prepare($query);
        $qb->bindValue(':email', $input_modif['email'], PDO::PARAM_STR);
        if ($verif_mdp === TRUE) {//on vérfi seulement si on modifie le mdp
            $qb->bindValue(':mdp', sha1('nfa' . $input_modif['mdp']), PDO::PARAM_STR);
        }
        $qb->bindValue(':civilite', $input_modif['civilite'], PDO::PARAM_INT);
        $qb->bindValue(':nom', $input_modif['nom'], PDO::PARAM_STR);
        $qb->bindValue(':prenom', $input_modif['prenom'], PDO::PARAM_STR);
        $qb->bindValue(':telephone', $input_modif['telephone'], PDO::PARAM_INT);
        $qb->bindValue(':adresse', $input_modif['adresse'], PDO::PARAM_STR);
        $qb->bindValue(':suspendu', 0, PDO::PARAM_INT); //0 ou 1
        $qb->bindValue(':type_user', $input_modif['type_user'], PDO::PARAM_STR); //SU,client,technicien,magasinier,receptionnste
        $qb->bindValue(':id_membre', $this->id_membre, PDO::PARAM_INT);
        $this->setHexaAuth($this->id_membre, $modif_hexa_auth);
        $verif_token = new VerifToken($input_modif['crypt']);
        $qb->execute(); //si patte blanche, on execute la requête
        Route::routage($this->nex_route); //voir fiche membre modifier
    }

    public function setHexaAuth($id_membre, $hexa_auth) {//on enregistre dans la bdd les autorisations
        //on enregistre les nouveaux autorisation
        $modif_auth = new Autorise();
        $modif_auth->ajouterAuth($id_membre, $hexa_auth); //recupère les valeurs hexa coché
    }

}

?>
