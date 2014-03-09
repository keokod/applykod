<?php

class Affaire {

    private $bdd;
    private $crypt; //crypt post
    private $id_affaire = NULL; //si null ajouter
    private $date_affaire;
    private $id_client;
    private $id_receptionniste;
    private $id_appareil = NULL; //si null ajouter
    private $remarque = NULL; //si null ajouter
    private $annuler; //à 0 si ajouter
    private $terminer; //à 0 si ajouter
    private $session_visiteur = NULL;

    public function __construct($crypt) {
        $this->session_visiteur = $_SESSION['visiteur']; //on récupère l'id membre 
        $this->bdd = Bdd::getIntance();
        $this->crypt = $crypt;
        //afficher le nom et le prénom de la personne concernante
        //  echo "affaire pour " . $visiteur->getNomVisiteur();
    }

    public function ajouterAffaire($affaire) {//ajouter un 
        //on ajouter l'appareil
        $add_appareil = new Appareil();
        //on enregistre l'appareil et on récupère son numéro appareil
        $id_appareil = $add_appareil->enregistreAppareil(
                $affaire['ref_appareil'], $affaire['num_serie'], $affaire['localisation']
        );

        $id_client = $this->session_visiteur->getMemNextAction();
        $date = new DateTime();
        $date_affaire = $date->format('d/m/y');
        $id_receptionniste = $this->session_visiteur->getIdVisiteur();

        $query = "INSERT INTO affaire(date,id_client,id_receptionniste,id_appareil,remarque,annuler,terminer) 
            VALUES(:date,:id_client,:id_receptionniste,:id_appareil,:remarque,:annuler,:terminer)";

        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':date', $date_affaire, PDO::PARAM_STR);
        $prep->bindValue(':id_client', $id_client, PDO::PARAM_INT);
        $prep->bindValue(':id_receptionniste', $id_receptionniste, PDO::PARAM_INT);
        $prep->bindValue(':id_appareil', $id_appareil, PDO::PARAM_INT);
        $prep->bindValue(':remarque', $affaire['remarque'], PDO::PARAM_STR);
        $prep->bindValue(':annuler', 0, PDO::PARAM_BOOL);
        $prep->bindValue(':terminer', 0, PDO::PARAM_BOOL);
        $prep->execute();
        $id_affaire = $this->bdd->lastInsertId();
        $this->session_visiteur->setMemNextAction($id_affaire);
        $this->session_visiteur->refreshVisiteur();
        Route::routage(4002); //fiche affaire
    }

    public function modifAffaire($input_affaire) {//on récupère les datas affaire pour les modifiers
        $query = "UPDATE appareil SET reference =:reference, numero_serie =:num_serie, localisation =:localisation WHERE id=:id_appareil;
            UPDATE affaire SET remarque =:remarque WHERE id=:id_affaire";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':reference', $input_affaire['ref_appareil'], PDO::PARAM_STR);
        $prep->bindValue(':num_serie', $input_affaire['num_serie'], PDO::PARAM_STR);
        $prep->bindValue(':localisation', $input_affaire['localisation'], PDO::PARAM_STR);
        $prep->bindValue(':id_appareil', $input_affaire['id_appareil'], PDO::PARAM_INT);

        $prep->bindValue(':remarque', $input_affaire['remarque'], PDO::PARAM_STR);
        $prep->bindValue(':id_affaire', $input_affaire['id_affaire'], PDO::PARAM_INT);

        $prep->execute();
        
        $this->session_visiteur->setMemNextAction($input_affaire['id_affaire']);
        $this->session_visiteur->refreshVisiteur();
        Route::routage(4002); //fiche affaire
    }

    public function recupficheAffaire($id_affaire) {
       
        //jointure entre affaire et le client
        $query = "SELECT AF.*,AP.*,M.email,M.nom,M.prenom,M.telephone,M.adresse
                    FROM affaire AF
                    JOIN appareil AP
                    ON AF.id_appareil =AP.id
                    JOIN membre M
                    ON AF.id_client = M.id 
                    WHERE AF.id =:id_affaire";

        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_affaire', $id_affaire, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch(PDO::FETCH_OBJ); //fetch pour 1 seul tuple
        return $data;
    }

    public function ajouterAppareilBdd($reference, $num_serie, $localisation) {
        $ajout_appareil = new Appareil();
        //on récupre last id de l'appareil
        $this->id_appareil = $ajout_appareil->enregistreAppareil($reference, $num_serie, $localisation);
    }

    public function resumAffaireClient($id_client) {//tout affaire avec ce client
        $query = 'SELECT A.id,A.date,A.id_receptionniste,A.annuler,A.terminer,AP.reference,AP.id as id_appareil,AP.localisation
            FROM affaire A
            JOIN appareil AP
            ON A.id_appareil=AP.id
            WHERE id_client=:id_client';
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_client', $id_client, PDO::PARAM_INT);
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_OBJ);
    }

    public function listeAffaire() {//on récupére avec I.etat is null pour les affaire non traité
        $query = 'SELECT A.id,A.date, A.id_client, A.id_appareil, M.nom as nom_client, P.reference, I.etat
        FROM affaire A
        JOIN membre M ON A.id_client = M.id
        JOIN appareil P ON A.id_appareil = P.id
        LEFT JOIN intervention I ON A.id = I.id_affaire 
        WHERE A.annuler = 0
        AND A.terminer = 0 
        AND I.etat is NULL
        ';

        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function listeAffaireTech($id_tech) {//on récupère les affaire en cours ou en estimation
        $query = 'SELECT DISTINCT A.id,A.date, A.id_client, A.id_appareil, M.nom as nom_client, P.reference, I.etat, I.id_tech
        FROM affaire A
        JOIN membre M ON A.id_client = M.id
        JOIN appareil P ON A.id_appareil = P.id
        LEFT JOIN intervention I ON A.id = I.id_affaire 
        WHERE A.annuler = 0
        AND A.terminer = 0 
        AND I.etat < 3
        AND I.id_tech =' . $id_tech . '
        GROUP BY I.id_affaire';

        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function chargeAffaireTech($id_affaire) {
        $query = "SELECT M.nom
            FROM membre M
            JOIN intervention I
            ON M.id = I.id_tech
            WHERE I.id_affaire =" . $id_affaire . "
                GROUP BY I.id_tech";
        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return($data);
    }

    public function chargeAffaireRecept($id_affaire) {
        $query = "SELECT M.nom
            FROM membre M
            JOIN affaire A
            ON M.id = A.id_receptionniste
            WHERE A.id =" . $id_affaire;

        $qb = $this->bdd->query($query);
        $data = $qb->fetch(PDO::FETCH_OBJ);
        return($data);
    }

    public function resumAffaire($id_affaire) {//on recherche toute la fiches affaire pour crée la facture
        $query = "SELECT M.* 
            FROM membre M
            JOIN affaire A
            ON M.id = A.id_client
            WHERE A.id =" . $id_affaire;
        $qb = $this->bdd->query($query);
        $data = $qb->fetch(PDO::FETCH_OBJ);
        return($data);
    }

    public function resumPiece($id_affaire) {//on recherche les pièces utilisers pour cette affaire
        $query = "SELECT S.* 
            FROM stock S
            JOIN piece_affaire A
            ON S.id = A.id_piece
            WHERE A.id_affaire =" . $id_affaire;
        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return($data);
    }

    public function resumInter($id_affaire) {
        $query = "SELECT I.* 
            FROM  affaire A
            JOIN intervention I
            ON A.id = I.id_affaire
            WHERE I.id_affaire =" . $id_affaire . "
            AND I.etat =3   ";
        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return($data);
    }

    public function affaireAppareil() {
        
    }

    /*
     * PROJET STEPHANE NGOV
     */
}

?>
