<?php

class Facture {

    private $bdd;
    private $session_visiteur;
    private $id;
    private $date;
    private $id_affaire;
    private $id_client;
    private $correction_total_ht;
    private $remarque;
    private $payer;

    public function __construct() {
        $this->date = new DateFr();
        $this->bdd = Bdd::getIntance();
        $this->session_visiteur = $_SESSION['visiteur'];
    }
    
    public function recupIdAffaire($id_facture)
    {
        $query="SELECT id_affaire FROM facture WHERE id=:id_facture";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_facture',$id_facture,  PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        return $data['id_affaire'];
    }

    public function creeFacture($input_facture) {
        $query = "INSERT INTO facture(date,id_affaire,correction_total_ht,remarque,payer)
            VALUES(:date,:id_affaire,:correction_total_ht,:remarque,:payer)";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':date', $input_facture['date'], PDO::PARAM_STR);
        $prep->bindValue(':id_affaire', $input_facture['id_affaire'], PDO::PARAM_INT);
        $prep->bindValue(':correction_total_ht', $input_facture['total'], PDO::PARAM_STR);
        $prep->bindValue(':remarque', $input_facture['remarque'], PDO::PARAM_STR);
        $prep->bindValue(':payer', 0, PDO::PARAM_INT);
        $prep->execute();
        //recupération du numéro de facture
        $id_facture = $this->bdd->lastInsertId();
        $this->session_visiteur->setMemNextAction($id_facture); //on récupérer l'id affaire      
        //mettre le champ teriner à 1
        $query_end = "UPDATE affaire SET terminer = 1 WHERE id=".$input_facture['id_affaire'];
        $qb = $this->bdd->query($query_end);
        $qb->execute();
        $email = new Courriel();
        $email->endAffaire('keo.n@free.fr', 'keo','ngov');
    }
    
    public function voirFacture($id_affaire)
    {
        $query="SELECT * FROM facture WHERE id_affaire=:id_affaire";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_affaire',$id_affaire, PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        return $data;
        
    }
}

/*PROJET STEPHANE NGOV V1.38**/

?>
