<?php

class FormPlug extends FormAnnuaire {
    private $tentative = 0;
   
    public function __construct($cible, $titre_form) {
        parent::__construct($cible, NULL);
        $this->formEmailMdp();      
    }  
}
//PROJET STEPHANE NGOV V1.10
?>
