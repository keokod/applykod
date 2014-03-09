<?php

class Piece {

    private $bdd = NULL;
    private $id = NULL;
    private $nom_piece = NULL;
    private $reference = NULL;
    private $quantite = NULL;
    private $fournisseur = NULL;
    private $prixHT = NULL;
    private $localisation = NULL;
    private $caracteristique = NULL;
    private $dimension = NULL;
    private $session_visiteur = NULL;

    public function __construct() {
        $this->bdd = Bdd::getIntance();
        $this->session_visiteur = $_SESSION['visiteur']; //on récupère l'id membre 
        //afficher le nom et le prénom de la personne concernante
        //  echo "affaire pour " . $visiteur->getNomVisiteur();
    }

    public function listePiecePanier($panier) {
        $query = "SELECT * FROM stock WHERE id IN(" . $panier . ")";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':panier', $panier, PDO::PARAM_STR);
        $prep->execute();
        $data = $prep->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function addPiece($input_form) {

        $query = "INSERT INTO 
            stock(nom_piece,reference,quantite,fournisseur,prixHT,localisation,caracteristique,dimension,id_chargeur)
            VALUES(:nom_piece,:reference,:quantite,:fournisseur,:prixHT,:localisation,:caracteristique,:dimension,:id_chargeur)";

        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':nom_piece', $input_form['nom_piece']);
        $prep->bindValue(':reference', $input_form['reference']);
        $prep->bindValue(':quantite', $input_form['quantite']);
        $prep->bindValue(':fournisseur', $input_form['fournisseur']);
        $prep->bindValue(':prixHT', $input_form['prixHT'], PDO::PARAM_STR);
        $prep->bindValue(':localisation', $input_form['localisation'], PDO::PARAM_STR);
        $prep->bindValue(':caracteristique', $input_form['caracteristique'], PDO::PARAM_INT);
        $prep->bindValue(':dimension', $input_form['dimension'], PDO::PARAM_STR);
        $prep->bindValue(':id_chargeur', $this->session_visiteur->getIdVisiteur(), PDO::PARAM_INT);
        //verif token avec $crypt
        $prep->execute();
        $id_piece = $this->bdd->lastInsertId(); //on récupère le numéro de la pièce enregistrer
        $this->session_visiteur->setMemNextAction($id_piece);
    }

    public function recupPiece($id_piece) {
        $query = "SELECT * FROM stock WHERE id =:id";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id', $id_piece, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        return $data;
    }

    public function listPiece() {
        $query = "SELECT * FROM stock ORDER BY id DESC LIMIT 0,10 ";
        $prep = $this->bdd->prepare($query);
        $prep->execute();
        $data = $prep->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

    public function modifPiece($input_form) {
        $query = "UPDATE stock SET 
            nom_piece=:nom_piece,reference=:reference,quantite=:quantite,fournisseur=:fournisseur,prixHT=:prixHT,
            localisation=:localisation,caracteristique=:caracteristique,dimension=:dimension,id_chargeur=:id_chargeur
            WHERE id=:id";
        //vérification avec le jeton $input_form['crypt'];
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id', $input_form['id'], PDO::PARAM_INT);
        $prep->bindValue(':nom_piece', $input_form['nom_piece']);
        $prep->bindValue(':reference', $input_form['reference']);
        $prep->bindValue(':quantite', $input_form['quantite']);
        $prep->bindValue(':fournisseur', $input_form['fournisseur']);
        $prep->bindValue(':prixHT', $input_form['prixHT'], PDO::PARAM_STR);
        $prep->bindValue(':localisation', $input_form['localisation'], PDO::PARAM_STR);
        $prep->bindValue(':caracteristique', $input_form['caracteristique'], PDO::PARAM_INT);
        $prep->bindValue(':dimension', $input_form['dimension'], PDO::PARAM_STR);
        $prep->bindValue(':id_chargeur', $this->session_visiteur->getIdVisiteur(), PDO::PARAM_INT);
        $prep->execute();
        $this->session_visiteur->setMemNextAction($input_form['id']);
    }

    public function dispoPiece($id_piece, $quantite) {
        //récupération du nombre de pièce
        $query = "SELECT quantite FROM stock WHERE id=:id_piece";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_piece', $id_piece, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        $verif_qte = $data['quantite'] - $quantite;
        return $verif_qte;
    }

    public function moinUn($id_piece, $quantite) {
        
        $query = "UPDATE stock SET quantite = quantite - 1 WHERE id=:id_piece ";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue('id_piece', $id_piece, PDO::PARAM_INT);
        $prep->execute();

    }
    
    public function plusUn($id_piece, $quantite) {
        
        $query = "UPDATE stock SET quantite = quantite + 1 WHERE id=:id_piece ";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue('id_piece', $id_piece, PDO::PARAM_INT);
        $prep->execute();

    }
    

    public function destock($id_affaire, $id_piece, $quantite) {
        //déstockage des pièces du stock
        $query = "SELECT quantite FROM stock WHERE id=:id_piece";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_piece', $id_piece, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        $qte_now = $data['quantite'] - $quantite;

        //mise à a jour du stock
        $query_update = "UPDATE stock SET quantite=:quantite WHERE id =:id_piece";
        $prep_update = $this->bdd->prepare($query_update);
        $prep_update->bindValue(':quantite', $qte_now, PDO::PARAM_INT);
        $prep_update->bindValue(':id_piece', $id_piece, PDO::PARAM_INT);
        $prep_update->execute();

        //corespondance d'ajout des pièces pour l'affaire numéro

        $query_aff = "INSERT INTO piece_affaire (id_affaire,id_piece,qte_utiliser) 
            VALUES (:id_affaire,:id_piece,:qte_utiliser)";
        $prep_aff = $this->bdd->prepare($query_aff);
        $prep_aff->bindValue(':id_affaire', $id_affaire, PDO::PARAM_INT);
        $prep_aff->bindValue(':id_piece', $id_piece, PDO::PARAM_INT);
        $prep_aff->bindValue(':qte_utiliser', $quantite, PDO::PARAM_INT);
        $prep_aff->execute();
    }

    public function pieceAffaire($id_affaire) {
        $query = "SELECT S.nom_piece, S.reference, S.prixHT, P.id_piece, P.qte_utiliser as nb 
            FROM stock S JOIN piece_affaire P ON S.id = P.id_piece WHERE P.id_affaire =:id_affaire";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_affaire', $id_affaire, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }

}