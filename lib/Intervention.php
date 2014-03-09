<?php

require_once '../lib/Ini.php';

class Intervention {

    private $bdd = NULL;
    private $id_inter = NULL; //numéro du future id_intervetion ou de l'id rechercher
    private $id_affaire = NULL;
    private $id_tech = NULL;
    private $date_inter = NULL;
    private $diagnostique = NULL;
    private $tache = NULL;
    private $duree = NULL;
    private $etat = NULL;
    private $session_visiteur = NULL;

    public function __construct() {
        $this->bdd = Bdd::getIntance();
        $this->session_visiteur = $_SESSION['visiteur'];
        $this->id_affaire = $this->session_visiteur->getMemNextAction(); //récupération du numéro affaire
        $this->id_tech = $this->session_visiteur->getIdVisiteur(); //récupérer id technicien
    }

    public function modifInter($input_form) {
        $query = "UPDATE intervention SET
            date_inter=:date_inter,id_affaire=:id_affaire,
            id_tech=:id_tech, tache=:tache, diagnostique=:diagnostique,
             duree=:duree, etat=:etat WHERE id=:id";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':date_inter', $input_form['date_inter'], PDO::PARAM_INT);
        $prep->bindValue(':id_affaire', $this->id_affaire, PDO::PARAM_INT);
        $prep->bindValue(':id_tech', $this->id_tech, PDO::PARAM_INT);
        $prep->bindValue(':tache', $input_form['tache'], PDO::PARAM_STR);
        $prep->bindValue(':diagnostique', $input_form['diagnostique'], PDO::PARAM_STR);
        $prep->bindValue(':duree', $input_form['duree'], PDO::PARAM_INT);
        $prep->bindValue(':etat', $input_form['etat'], PDO::PARAM_INT);
        $prep->bindValue(':id', $input_form['id'], PDO::PARAM_INT);
        $verif_token = new VerifToken($input_form['crypt']); //on vérifie le jeton
        $prep->execute();
        $_POST['id_inter'] = $input_form['id']; //on charge dans le poste le numéro de la nouvelle intervention
        //on vide les chamsp remplis
        $this->session_visiteur->clearInputForm();
        Route::routage(6002); //vers fiche intervention  
    }

    public function addInter($input_form) {//récupération des champs saisies et vérfier
        //on rechercher le futur numéro d'intervention
        $query = "INSERT INTO intervention(date_inter,id_affaire,id_tech,tache,diagnostique,duree,etat)
            VALUES (:date_inter,:id_affaire,:id_tech,:tache,:diagnostique,:duree,:etat)";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':date_inter', $input_form['date_inter'], PDO::PARAM_STR);
        $prep->bindValue(':id_affaire', $this->id_affaire, PDO::PARAM_INT);
        $prep->bindValue(':id_tech', $this->id_tech, PDO::PARAM_INT);
        $prep->bindValue(':tache', $input_form['tache'], PDO::PARAM_STR);
        $prep->bindValue(':diagnostique', $input_form['diagnostique'], PDO::PARAM_STR);
        $prep->bindValue(':duree', $input_form['duree'], PDO::PARAM_INT);
        $prep->bindValue(':etat', $input_form['etat'], PDO::PARAM_INT);
        $verif_token = new VerifToken($input_form['crypt']); //on vérifie le jeton
        $prep->execute();
        $_POST['id_inter'] = $this->bdd->lastInsertId(); //on charge dans le poste le numéro de la nouvelle intervention
        //on vide les chamsp remplis
        $this->session_visiteur->clearInputForm();

        Route::routage(6002); //vers fiche intervention   
    }

    public function listeInter($id_affaire) {
        $query = "SELECT * FROM intervention WHERE id_affaire=:id_affaire";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_affaire', $id_affaire, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function voirInter($id_inter) {
        $query = "SELECT * FROM intervention WHERE id=:id_inter";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_inter', $id_inter, pdo::PARAM_INT);
        $prep->execute();
        $data = $prep->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function recupInter($id_inter) {
        $query = "SELECT * FROM intervention WHERE id=:id_inter";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_inter', $id_inter, pdo::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        return $data;
        
        /*
          $this->id_tech = $data->id_tech;
          $this->date_inter = $data->date_inter;
          $this->diagnostique = $data->diagnostique;
          $this->tache = $data->tache;
          $this->duree = $data->duree;
          $this->stat = $data->stat;
         * 
         */
    }

}

?>
