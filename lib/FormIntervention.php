<?php

class FormIntervention extends Form {

    private $id_inter = NULL; //numéro intervention
    private $date_inter = NULL;
    private $diagnostique = NULL;
    private $tache = NULL;
    private $duree = NULL;
    private $etat = 1;
    private $localisation;

    public function __construct($cible, $titre_form) {
        parent::__construct($cible, $titre_form,'intervention');    
        $this->date_inter  = $this->form_date;
    }
    
    public function hydrateModifierInter($input_form)//par post    
    {
        
    }

    public function hydratFormInter($input_form) {//hyrate par post array indice
        $this->id_inter = $input_form['id'];
        $this->date_inter = $input_form['date_inter'];
        $this->diagnostique = $input_form['diagnostique'];
        $this->tache = $input_form['tache'];
        $this->duree = $input_form['duree'];
        $this->etat = $input_form['etat'];
    }

    public function add_inter() {//ajouter un modifier une intervention
        ?>
        <input type="hidden" name="id" value="<?php echo $this->id_inter?>">
        <input type="hidden" name="date_inter" value="<?php echo $this->form_date ?>">
        dynagnostique :<br/><textarea name="diagnostique"><?php echo $this->diagnostique; ?></textarea><br/>
        tache :<br/><textarea name="tache"><?php echo $this->tache; ?></textarea><br/>
        <label>durée:</label><br/>
        <input type="text" name="duree" value="<?php echo $this->duree; ?>"> en heure<br/>
        <label>etat :</label><br/>
        <select name="etat">
            <option value="1">estimation</option>
            <option value="2">en cours</option>
            <option value="3">terminer</option> 
            <option value="4">annuler</option>
        </select><br/>  
        <?php
    }
    
            

}
?>
