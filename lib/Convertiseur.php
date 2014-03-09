<?php

class Convertiseur {
    
    private $a_convertir; 
    private $tb_resultat; //sous forme de table
    private $resultat;//sous forme de srting ou de nombre


    public function __construct($a_convertir) {
        $this->a_convertir =$a_convertir;               ;
    }
    
    public function to2Bit()//permet de couper la chaine hexa en 2 bit sous une table
    {
        $this->tb_resultat = str_split($this->a_convertir);
    }
    
    public function bin2hex()//permet de transformer du binaire en hexadécimal
    {
        $this->resultat = dechex($this->a_convertir);     
    }
    
    
}

?>
