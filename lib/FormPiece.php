<?php

class FormPiece extends Form {

    private $id = NULL;
    private $nom_piece = NULL;
    private $reference = NULL;
    private $quantite = NULL;
    private $fournisseur = NULL;
    private $prixHT = NULL;
    private $localisation = NULL;
    private $caracteristique = NULL;
    private $dimension = NULL;

    public function __construct($cible, $titre_form) {
        parent::__construct($cible, $titre_form,'piece');
        $this->session_visiteur = $_SESSION['visiteur'];
    }

    public function hydartModifierPiece($form_input) {
        $this->id = $form_input->id;
        $this->nom_piece = $form_input->nom_piece;
        $this->reference = $form_input->reference;
        $this->quantite = $form_input->quantite;
        $this->fournisseur = $form_input->fournisseur;
        $this->prixHT = $form_input->prixHT;
        $this->localisation = $form_input->localisation;
        $this->caracteristique = $form_input->caracteristique;
        $this->dimension = $form_input->dimension;
    }

    public function hydrateFormPiece($form_input) {
        $this->id = $form_input['id'];
        $this->nom_piece = $form_input['nom_piece'];
        $this->reference = $form_input['reference'];
        $this->quantite = $form_input['quantite'];
        $this->fournisseur = $form_input['fournisseur'];
        $this->prixHT = $form_input['prixHT'];
        $this->localisation = $form_input['localisation'];
        $this->caracteristique = $form_input['caracteristique'];
        $this->dimension = $form_input['dimension'];
    }

    function formInputPiece() {
        ?>
        <input type="hidden" name="id" value="<?php echo $this->id ?>"><br/>
        <label>nom piece:</label><input type="text" name="nom_piece" value="<?php echo $this->nom_piece ?>"><br/>
        <label>reference :</label><input type="text" name="reference" value="<?php echo $this->quantite ?>"><br/>
        <label>quantite :</label><input type="text" name="quantite" value="<?php echo $this->quantite ?>"><br/>
        <label>fournisseur :</label><input type="text" name="fournisseur" value="<?php echo $this->fournisseur ?>"><br/>
        <label>prixHT :</label><input type="text" name="prixHT" value="<?php echo $this->prixHT ?>"><br/>
        <label>localisation </label><input type="text" name="localisation" value="<?php echo $this->localisation ?>"><br/>
        <label>description</label>
        <textarea name="caracteristique"><?php echo $this->caracteristique ?></textarea>
        <label>dimension </label><input type="text" name="dimension" value="<?php echo $this->dimension ?>"><br/>
        <?php
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
