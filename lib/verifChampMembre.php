<?php

class verifChampMembre extends Verif {

    public function __construct() {
        parent::__construct();
    }

    public function verifChampAnnuaire($champs_saisie) {//on vérifie que les champs son correctement remplis
        extract($champs_saisie);
        $this->validEmail($email);
        $this->strMinMax($mdp, 4, 8, 'mot de passe'); //4 = minimum caractère 8 = max caractere
        $this->validMdp($mdp, $confirm_mdp);
        $this->validSelect($civilite, 0, 3, 'civilite'); //civilité doit être supérieur à et inférieur ou égal à 3
        $this->strMinMax($nom, 2, 50, 'nom de famille'); //le caractère de nom doit être compris entre 2 et 50 caractere
        $this->validNom($nom);
        $this->strMinMax($prenom, 2, 50, 'prénom');
        $this->validPrenom($prenom);
        $this->strMinMax($adresse, 3, 300, 'adresse');
        $this->validAdresse($adresse);
        $this->validTelephone($telephone);
        if ($this->getCollectErr() != NULL) {//si erreur on enregistre les erreurs à afficher
            $visiteur = $_SESSION['visiteur'];
            $visiteur->setErreur($this->getCollectErr());
            $visiteur->refreshVisiteur();
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}

?>
