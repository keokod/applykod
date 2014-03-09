<?php

require_once 'Ini.php';

class Desinscription extends Inscription {

    private $id_membre = NULL;

    public function __construct($_post_crypt) {
        parent::__construct($_post_crypt);
    }

    public function isExistMembre($id_membre) {
        $this->id_membre = $id_membre;
        $query = "SELECT id,nom FROM membre WHERE id =:id_membre";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
        // $verif = new Verif();
        //$verif->validToken($this->crypt);//si jeton périmé, page erreur
        $prep->execute();
        $data = $prep->fetch();
        if (empty($data)) {
            echo "pas de membre";
            Route::routage(7003); //membre existe pas
        }
        $this->killMembre();
    }

    public function killMembre() {
        $query = "DELETE FROM membre WHERE id=:id_membre";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_membre', $this->id_membre, PDO::PARAM_INT);
        $prep->execute();
        Route::routage(7004); //redirection suppresion        
    }

}

?>
