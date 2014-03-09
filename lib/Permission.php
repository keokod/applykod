<?php

require_once '../lib/Ini.php';

class Permission {

    private $autorise_actions = array(); //voir,modifier, ajoutre ...
    private $autorise_page = array(); //technicien, client ...
    
    private $permis = array();//numéro des permission 

    public function __construct($id_membre, $fonction_principal, $permis) {
        echo "<h1>vous avez comme role =" . $fonction_principal . "<h1>";
        echo "<h1>vous avez avec le numéro membre =" . $id_membre . "<h1>";

        print_r($permis); //table des permission    

        $this->calculRole($fonction_principal);
        $this->getService($permis);

        if ($fonction_principal != 1) {//permission normal
            $query = "SELECT id_permis  FROM mbre_permission WHERE id_membre=:id_membre";
            $bdd = Bdd::getIntance();
            $prep = $bdd->prepare($query);
            $prep->bindValue(':id_membre', $id_membre, PDO::PARAM_INT);
            $prep->execute();

            while ($data = $prep->fetch(PDO::FETCH_OBJ)) {
                $this->permis[] = $data->id_permis;
            }
        } else { //si sa fonction principal est SU =1 alors on donne tout les pouvoirs
        }
    }
    
//vérification de quel service (recetionniste, technicien) il a accès
    public function autoriseService() {
//on recherche les roles secondaire select * from table role wher id= fonction_principal
        $fonction_total = array();
        foreach ($fonction_total as $F) {
            switch ($F) {
                case 1:
                    break;
                case 2:
                    break;
                case 2:
                    break;
            }
        }
    }

//vérification de quel actions (modifer, editer, voir)  il a accès
    public function auroriseAction() {
        foreach ($this->permis as $A)
            switch ($A) {
                case 1:
                    break;
            }
    }

}

?>
