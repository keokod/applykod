<?php
require_once '../lib/Ini.php';

class FormRecherche extends Form {

    protected $table = NULL;
    protected $champ = NULL;
    protected $mot_cle = NULL;

    public function __construct($cible, $titre_form) {
        parent::__construct($cible, $titre_form,'recherche');
        //formulaire de base de recherche
    }
    
    public function formRecherche()
    {
                ?>
        <input type="hidden" name="table" value="<?php echo $this->table ?>">
        <input type="hidden" name="champ" value="<?php echo $this->champ ?>">
        <input onBlur="vldMinChar(this,3)" type="text" name="mot_cle" size="10" value="<?php echo $this->mot_cle ?>">
        <?php
    }

}

/*
 * PROJET STEPHANE NGOV
 */
?>
