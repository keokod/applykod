<?php

require_once '../lib/Ini.php';

class Autorise {

    private $action = array(); //id_action = supprimer, editer, ....
    private $fonction = array(); //fonction = technique,client ..
    //calcul des nouveau autorisation entre les anciens autorisation et les case coché
//hexa_auth est un table qui contient les permissions en 2 bits hexadécimal  
    private $id_membre;
    private $a_cocher = array(); // on récupère les autrisation coché

//on décompose les fonction est les action

    public function __construct() {//fonction = technique,..action = modifier
    }

    public function killAuth($id_membre) {
        $query = "DELETE FROM auth_membre WHERE id_membre =:id_membre";
        $bdd = Bdd::getIntance();
        $prep = $bdd->prepare($query);
        $prep->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
        $prep->execute();
    }

    public function ajouterAuth($id_membre,$hexa_auth) {
        
        $this->killAuth($id_membre);//on supprimet tout les autorisations de ce membre
        $query = "INSERT INTO auth_membre(id_membre,hexa_auth)VALUES(:id_membre,:new_auth)";
        $bdd = Bdd::getIntance();
        $prep = $bdd->prepare($query);
        foreach ($hexa_auth as $H) {
            $prep->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
            $prep->bindValue(':new_auth', $H);
            $prep->execute();
        }
    }

    public function getAuthBdd($id_membre) {
        //on recherche les autorisations de ce membre
        $query = "SELECT * FROM auth_membre WHERE id_membre =:id_membre ";
        $bdd = Bdd::getIntance();
        $prep = $bdd->prepare($query);
        $prep->bindValue(':id_membre', $id_membre, pdo::PARAM_INT);
        $prep->execute();
        $bdd_auth = array();
        //on récupère les autorisations du membre existant
        while ($data = $prep->fetch(PDO::FETCH_OBJ)) {
            $bdd_auth[] = $data->hexa_auth;
        }
        return $bdd_auth; //retourn tout les autorisations des membres
    }
    
    public function listeAuth($auth)
    {
        $query = 'SELECT action FROM info_hexa WHERE valeur_hexa = "'.$auth.'" ';
        
        $bdd = Bdd::getIntance();
        $qb = $bdd->query($query);
        $data = $qb->fetch();
        if($data != NULL)
        {
        return $data['action'];
        }
    }

        
    /*
    static function voirAuth($array_hexa_auth)//array les autorisations que possède le membre
    {
        $query = 'SELECT action FROM info_hexa WHERE valeur_hexa IN ('.$array_hexa_auth.')';
        $bdd = Bdd::getIntance();
        $qb = $bdd->query($query);
        $qb->execute();
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        return $data;
    }
     * 
     */
}
