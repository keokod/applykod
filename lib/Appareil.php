<?php

class Appareil {

    private $bdd;
    private $id_appareil = NULL;
    private $reference;
    private $numero_serie;
    private $localisation;
    
    public function __construct() {
        $this->bdd = Bdd::getIntance();
    }


    public function enregistreAppareil($reference, $numero_serie,$localisation) {
        $query = "INSERT INTO appareil(reference,numero_serie,localisation) VALUES(:reference,:numero_serie,:localisation)";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':reference', $reference, PDO::PARAM_STR);
        $prep->bindValue(':numero_serie',$numero_serie, PDO::PARAM_STR);
        $prep->bindValue(':localisation',$localisation, PDO::PARAM_STR);
        $prep->execute();
        return $this->bdd->lastInsertId();
    }

    public function recupAppareil($id_appareil) {
        $query="SELECT * FROM appareil WHERE id =:id_appareil";
        $prep = $this->bdd->prepare($query);
        $prep->bindValue(':id_appareil', $id_appareil,  PDO::PARAM_INT);
        $prep->execute();
        $data = $prep->fetch();
        return $data;
    }
    
    public function sortirAppareil($id_appareil){
       $query ="UPDATE appareil SET localisation = 'sortie' WHERE id =:id_appareil";
       $prep = $this->bdd->prepare($query);
       $prep->bindValue(':id_appareil', $id_appareil,  PDO::PARAM_INT);
       $prep->execute();
    }
            
    


}

?>
