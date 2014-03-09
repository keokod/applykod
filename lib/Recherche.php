<?php

require_once '../lib/Ini.php';

class Recherche {

    protected $bdd;
    protected $table = NULL;
    protected $champ = NULL;
    protected $mot_cle = NULL;
    protected $session_visiteur;
    protected $crypt = NULL;
    protected $condition = NULL;
    protected $auth_visiteur = NULL;
    protected $next_route = NULL;

    public function __construct($input_recherche) {

        $this->bdd = Bdd::getIntance();
        $this->session_visiteur = $_SESSION['visiteur'];
        $this->next_route = $this->session_visiteur->getNextRoute();
        $this->auth_visiteur = $this->session_visiteur->getHexaAuthVisiteur();
        //$this->auth_visiteur = $this->session_visiteur->getHexaAuthVisiteur();
        $this->table = $input_recherche['table'];
        $this->champ = $input_recherche['champ'];
        $this->mot_cle = $input_recherche['mot_cle'];
        $this->crypt = $input_recherche['crypt'];
    }

    public function findConditionTypeMembre($sujet) {
        $query = 'SELECT *  FROM ' . $this->table . ' WHERE ' . $this->champ . '  LIKE "%' . $this->mot_cle . '%" ' . $sujet;
        $this->requete($query);
    }

    public function findSimpleChamp() {
        $query = 'SELECT *  FROM ' . $this->table . ' WHERE ' . $this->champ . '  LIKE "%' . $this->mot_cle . '%" ';
        $this->requete($query);
    }

    public function requete($query) {
        $this->autoriseRecherche(); //vérifie si on a le droit ou pas
        $qb = $this->bdd->query($query);
        $data = $qb->fetchAll(PDO::FETCH_OBJ);
        $this->session_visiteur->setResultFind($data);
        $this->session_visiteur->refreshVisiteur();

            Route::routage($this->next_route);

            /*
        if ($this->session_visiteur->getTypeUserVisiteur == "SU") {
            Route::routage(7005);
        } else {
            Route::routage(1005);
        }
             * 
             */
    }

    public function autoriseRecherche() {
        //si ne contient pas FF on vérifie les autorisations
        if (!in_array('FF', $this->auth_visiteur)) {
            if ($this->table == "membre") {//si on n'a pas les lse autorisations 82 et 10 redirection
                if (!(in_array('82', $this->auth_visiteur) || in_array('10', $this->auth_visiteur))) {
                    $this->session_visiteur->setFlashInfo("pas de résultat");
                    
                    Route::routage(7005);
                }
            }
        }
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
