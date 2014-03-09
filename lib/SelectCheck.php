<?php

require_once '../lib/Ini.php';
//cettte class permet de transcrire les sélections et check box 
class SelectCheck {
    
    protected $select_check;
    
    public function __construct($input_form_select_check) {//on récupère le poste
        $this->select_check = $input_form_select_check;     
    }
    
}

?>
