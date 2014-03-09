<?php

class Courriel {

    private $expediteur = "web@keokod.com";

    public function __construct() {

    }

    public function sendMdp($pif_mdp, $mail_membre, $membre_nom, $membre_prenom) {
        
        $sujet ="identifant de connexion SAV NFA";

        $headers ="From:<web@keokod.com>\r\n";
        $headers.="Bcc:<keo.n@free.fr>\r\n";
	$headers.='MIME-Version: 1.0'."\r\n";
   	$headers.='Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers.="r\n";

        $message="<p>Bonjour ".$membre_prenom."   ".$membre_nom."</p>
            <p>
                Notre service client SAV NFA &#224; le plaisir de vous fournir vos identifiant acc&egrave;s
                notre plate-forme de communication.<br/>
                vous pouvez consulter l	&acute;avancement de notre service<br/>
            </p>
            <p>
                <label>votre courriel (login) :</label>" . $mail_membre . "<br/>
                <label>votre mot de passe </label> :</label>" . $pif_mdp . "<br/>
                
            </p>
            <p>
                Cordialement, le service client.
            </p>";

        mail($mail_membre, $sujet, $message, $headers);
    }

    public function endAffaire($mail_membre, $membre_nom, $membre_prenom) {
        
        $sujet ="SAV NFA - Information sur l'avancement de votre appareil";

        $headers ="From:".$this->expediteur."\r\n";
        $headers.="Bcc:<keo.n@free.fr>\r\n";
	$headers.='MIME-Version: 1.0'."\r\n";
   	$headers.='Content-type: text/html; charset=iso-8859-1'."\r\n";
        $headers.="r\n";
        $message="<p>Bonjour ".$membre_prenom."   ".$membre_nom."</p>
            <p>
                Notre service client SAV NFA &#224; le plaisir de vous informer que votre appareil est pr&ecirc;t et répar&eacute;
            </p>
            <p>
                Cordialement, le service client.
            </p>";

        mail($mail_membre, $sujet, $message, $headers);
    }
              
}

/*PROJET STEPHANE NGOV V1.50**/
?>
