<?php
require_once '../lib/Ini.php';


class Erreur {
    
    private $message_err = NULL; 
    private $collect_erreur = array();
    
    public function __construct(){ 
             
    }
       
    public function collectErr($erreurs) //collecte des erreurs
    {
        $this->code_erreur[] = $erreurs;
    }
    
    public function analyseErr()
    {
        foreach ($this->code_erreur as $E)
        {
            switch ($E)
            {
                case 0:
                    
                break;
            }
        }
    }

        public function getErreur()//return la tables des erreurs pour le test développement;
    {
        return $this->code_erreur;
    }
    
    public function getMessageErreur() //return les messages d'erreur pour le visiteur
    {
        return $this->message_err;
    }
        
}

?>
