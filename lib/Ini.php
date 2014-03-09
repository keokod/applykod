<?php
session_start();

class Bdd {

    public static function getIntance() {
        try {
            $instance = new PDO('mysql:host=localhost;dbname=test', 'root', '');
;
        } catch (PDOException $e) {
                echo "Problème de oonnexion à la base de donnée";
        }
        return $instance;
    }
}

function __autoload($class) {
    $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    require_once($path . '.php');
}
/*PROJET STEPHANE NGOV V1.40**/
?>
