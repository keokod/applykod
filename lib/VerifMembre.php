<?php

require_once '../lib/Ini.php';

class VerifMembre extends Verif {

    public function __construct($input_form) {
        parent::__construct($input_form); //le champs à vérifier , si echec on le réutilise pour l'hydrater       
    }

    public function validEmail($email) {//email
        if (preg_match('#^[a-z0-9.-_]+@[a-z0-9.-_]{2,}\.[a-z]{2,4}$#', $email)) {

            $membre = new Membre();
            $is_exist_email = $membre->isEmailExist($email,  $this->input_form['id_membre']);

            if ($_SESSION['visiteur']->getAjouterOrModifier() == 'M') { //en mode modif on ne vérifie pas l'existance de celui-ci
                $is_exist_email = FALSE; 
            }
            if ($is_exist_email == TRUE) { // si ce mail existe déjà
                $this->collect_err[] = $email . " est déjà utilier";
            } else {
                return TRUE;
            }
        } else {
            $this->collect_err[] = $email . " est un email est invalide";
        }
    }

    public function validTelephone($telephone) {
        if (preg_match("#^[0-9]{10}$#", $telephone)) {
            return TRUE;
        } else {
            $this->collect_err[] = $telephone . " est un numéro non valide ";
        }
    }

    public function verifSimpleAnnuaire() {//vérification de tous le champs sauf mdp + à cocher
        $this->validLimitStr($this->input_form['nom'], 3, 50, 'NOM de famille '); //le caractère de nom doit être compris entre 2 et 50 caractere
        $this->validAlpha($this->input_form['nom']);

        $this->validLimitStr($this->input_form['prenom'], 3, 50, 'PRENOM '); //le caractère de nom doit être compris entre 2 et 50 caractere
        $this->validAlpha($this->input_form['prenom']);

        $this->validLimitStr($this->input_form['adresse'], 5, 300, 'ADRESSE');
        $this->validAlphaNum($this->input_form['adresse'], "ADRESSE");

        $this->validTelephone($this->input_form['telephone']);

        $this->validEmail($this->input_form['email']);
    }

    public function verifMdp() {//Quand on ajoutre on vérifi le mdp
        $this->validLimitStr($this->input_form['mdp'], 6, 8, '   mot de passe');
        $this->validAlphaNum($this->input_form['mdp'], "--  confirm mot de passe");
        $this->validLimitStr($this->input_form['confirm_mdp'], 6, 8, "confirm mot de passe");
        $this->validAlphaNum($this->input_form['confirm_mdp'], "confirmation mdp");
        $this->validCoupleMdp($this->input_form['mdp'], $this->input_form['confirm_mdp']);
        $this->dispMdpMembre($this->input_form['mdp']);
    }

    public function dispMdpMembre($mdp) {
        $query = "SELECT mdp FROM Membre WHERE mdp =:mdp";
        $bdd = Bdd::getIntance();
        $prep = $bdd->prepare($query);
        $prep->bindValue(':mdp', sha1("nfa" . $mdp));
        $prep->execute();
        $data = $prep->fetch();
        if (!empty($data)) {//si on trouve le mdp, déjà pris
            $this->collect_err[] = "Le mot de passe est déjà pris ";
        }
    }

    public function validCoupleMdp($mdp, $confirm_mdp) {
        if ($mdp === $confirm_mdp) {
            return TRUE; //si les champs mots de passe ok, on renvoie true
        } else {
            $this->collect_err[] = "vos 2 champs mot de passe ne correspondent pas";
        }
    }

    /*
     * //on vérfie les mots de passe, même si on est en mod modif 
      if ($ajouter_or_modifier === 'A' || ( $ajouter_or_modifier === 'M' && !empty($mdp))) {
      $verif_mdp = TRUE; //on vérifie le mot de passe, on réactive la modification du mdp
      $verif->strMinMax($mdp, 4, 8, 'mot de passe'); //4 = minimum caractère 8 = max caractere
      }
     */
}

?>
