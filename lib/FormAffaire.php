<?php

class FormAffaire extends Form {

    private $id_affaire = NULL;
    private $id_receptionniste = NULL; //qui a fait l'affaire
    private $id_client = NULL;
    private $nom_receptionniste = NULL;
    private $date_affaire = NULL;
    private $terminer = NULL; //true ou false
    private $remarque; // exemple abandon de l'affaire
    //appareil
    private $id_appareil = NULL; //null si on ajoute
    private $ref_appareil = NULL;
    private $num_serie = NULL;
    private $localisation = NULL;

    public function __construct($cible, $titre_form) {
        parent::__construct($cible, $titre_form, 'affaire');
        $this->session_visiteur = $_SESSION['visiteur'];
        if ($this->session_visiteur->getInputForm() != NULL) {//on erreur formulaire affaire on récupère le poste pour réhydrater
            $this->hydrateAjouterAffaire($this->session_visiteur);
        }
    }

    public function hydrateAjouterAffaire() {

        if ($this->session_visiteur->getAjouterOrModifier() == 'M') {
            $affaire = $this->session_visiteur->getInputForm();
            $this->date_affaire = $affaire['date_affaire'];
            $this->id_receptionniste = $affaire['id_receptionniste'];
            $this->nom_receptionniste = $affaire['nom_receptionniste'];
            $this->ref_appareil = $affaire['ref_appareil'];
            $this->num_serie = $affaire['num_serie'];
            $this->localisation = $affaire['localisation'];
            $this->id_appareil = $affaire['id_appareil'];
            $this->remarque = $affaire['remarque'];
        }
    }

    public function hydrateModifierAffaire($affaire) {
        
    }

    public function hydrateAffaire($input_appareil) {//on hydrate pour préremplir le formulaire appareil
        $this->id_affaire = $this->session_visiteur->getMemNextAction(); //récupération de l'id affaire à modifier
        $this->id_appareil = $input_appareil->id;
        $this->ref_appareil = $input_appareil->reference;
        $this->num_serie = $input_appareil->numero_serie;
        $this->localisation = $input_appareil->localisation;
        $this->remarque = $input_appareil->remarque;
        
    }

    function formInputAppareil() {
        ?>

        <input type="hidden" name="date_affaire" value="<?php echo $this->date_affaire ?>"><br/>
        <input type="hidden" name="id_affaire" value="<?php echo $this->id_affaire ?>"><br/> 
        <label>reférérence appareil :</label><input type="text" name="ref_appareil" value="<?php echo $this->ref_appareil ?>"><br/>
        <label>numéro de série :</label><input type="text" name="num_serie" value="<?php echo $this->num_serie ?>"><br/>
        <label>localisation :</label><input type="text" name="localisation" value="<?php echo $this->localisation ?>"><br/>
        <!-- remarque sur la fiche affaire -->
        <label>remarque :</label>
        <textarea name="remarque"><?php echo $this->remarque ?></textarea>
        <input type="hidden" name="id_appareil" value="<?php echo $this->id_appareil ?>">
        <?php
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
