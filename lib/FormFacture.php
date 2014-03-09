<?php

class FormFacture extends Form {

    private $id = NULL;
    private $id_affaire = NULL;
    private $date = NULL;
    private $id_client = NULL;
    private $correction_total_ht = NULL;
    private $remarque = NULL;
    private $payer = FALSE;

    public function __construct($cible, $titre_form) {
        parent::__construct($cible, $titre_form,'facture');
        $this->session_visiteur = $_SESSION['visiteur'];
            $this->id_affaire = $this->session_visiteur->getMemNextAction(); //on récupérer l'id affaire
        if ($this->session_visiteur->getInputForm() != NULL) {//on erreur formulaire affaire on récupère le poste pour réhydrater
          //  $this->hydrateAjouterFacture($this->session_visiteur);
            //affichage des erreurs
            $this->session_visiteur->getErreur();
        }
    }

    public function hydrateAjouterFacture() {

    }

    public function hydrateModifierAffaire($affaire) {
        
    }

    function formInputFacture($total) {
        ?>  
        <input type="hidden" name="id_affaire" value="<?php echo $this->id_affaire ?>">
        <input type="hidden" name="date" value="<?php echo $this->date ?>">
        <label>correction du prix : </label>
        <input type="text" name="total" value="<?php echo $total ?>"> euros<br/>
        <label>remarque</label>
        <textarea name="remarque"><?php echo $this->remarque ?></textarea><br/>

        <?php 
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
