<?php
include'Courriel.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mdp
 *
 * @author linux-keo
 */
class Mdp {
    
    private $caractere = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-123456789';
    private $pif_mdp = NULL;
    
    public function __construct() {
        //création d'un mot de passe obligatoire
        $pif_mdp = uniqid(time());
        $pif_mdp = substr($pif_mdp,-6);
        $this->pif_mdp = $pif_mdp;
    }
    
    public function envoyMdp($mail_membre,$nom_membre,$prenom_membre)
    {
        $send_mail = new Courriel();
        $send_mail->sendMdp($this->pif_mdp, $mail_membre, $nom_membre, $prenom_membre);
    }
    
    public function getNewMdp()
    {
        return $this->pif_mdp;
    }
    
}
?>
