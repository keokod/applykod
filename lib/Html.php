<?php
require_once '../lib/Ini.php';

class Html {

    private $head_plus; //ATTRIBUT POUR CHARGER DES CSS OU JS SUPPLEMENTAIRE
    private $session_visiteur = NULL;
    private $page_public = array();
    private $qui_se_connecte = NULL;
    private $type_user_visiteur = NULL;
    private $css_theme = "../public/css";
    private $titre_page = NULL;

    public function __construct($titre_page) {//préparation de la page HTML
        ?>
        <!DOCTYPE html>
        <meta charset="utf-8">
        <head>
            <title><?php echo $this->titre_page = $titre_page ?></title> 
            <link rel=stylesheet type="text/css" href="<?php echo $this->css_theme ?>/global.css">
            <link rel=stylesheet type="text/css" href="<?php echo $this->css_theme ?>/menu_sav.css">
            <script type="text/javascript" src="../js/valid_input.js"></script>
            <?php
            if (isset($_SESSION['visiteur'])) {//si le visiteur s'est connecté on collecte son nom est son type d'utilisateur
                $this->session_visiteur = $_SESSION['visiteur'];
                //récupérer du nom pour afficher qui se connecte
                $this->qui_se_connecte = $this->session_visiteur->getNomVisiteur();
                $this->type_user_visiteur = $this->session_visiteur->getTypeUserVisiteur();

                if ($this->session_visiteur->getHexaAuthVisiteur() != NULL) {//on vérifie si c'est un SU 
                    if (in_array('FF', $this->session_visiteur->getHexaAuthVisiteur())) {//SI SU alors on charge le css admin
                        ?>
                        <link rel=stylesheet type="text/css" href="<?php echo $this->css_theme ?>/admin.css">

                        <?php
                    }
                }
            }
        }

        public function headPlus($plus_context) { // méthode pour ajouter les css et js dans le heade
            echo $plus_context;
        }

        public function banniere() {//AFFICHAGE HEADER = MENU FIXE + BANNIERE
            ?>
        </head>
        <body>
            <header>
                <div id="menu_context">
                    <span class="titre_menu_fix"><a href="http://localhost/nfa/public/">HOME - </a>  <a><?php echo $this->titre_page; ?></a></span>
                    <?php
                    if (isset($_SESSION['visiteur']) && $_SESSION['visiteur']->getHexaAuthVisiteur() != NULL) {
                        //AFFICHAGE DU MEMBRE CONNECTE + DU LIEN DE DECONNEXION APPLICATION 
                        ?>
                        <a><?php echo $this->type_user_visiteur . " " . $this->qui_se_connecte ?> est connecté</a>
                        <a  id="deconnexion" href="../app/deconnexion.php"><img src='../public/image/px/exit.png'></a>

                    </div>
                    <?php
                } else {
                    //FORMULAIRE DE CONNEXION ACCUEIL
                    $form_plug = new FormAnnuaire('../app/verif_saisie_connexion.php', 'connexion','connexion');
                    $form_plug->formLoggin();
                    $form_plug->endForm('connexion');

                    $visiteur = $_SESSION['visiteur'];
                    echo '<span class="rouge" id="flash_connexion">' . $visiteur->getFlashInfo() . '</span>';
                }
                // LA BALISE FERMANTE HEADER SE TROUVE DANS la méthode navMenu
            }

            public function navCategorie($tb_liens) {//pour afficher menu horizontal
                $this->navMenu($tb_liens, 'horizontal');
                ?>
                <?php
            }

            public function navMenu($tb_liens, $css) {//décompose la table en lien 
                echo ' <nav id="' . $css . '">
                            <ul >'; //on determine le css si c'est un menu horizontal ou vertical ou autre chose
                if (is_array($tb_liens)) {
                    foreach ($tb_liens as $T) {
                        echo '<li><a href="' . $T['url'] . '" > ' . $T['lien'] . '</a></li>';
                    }
                }
                echo '</ul>
                            </nav>';
                if ($css == 'horizontal') {//BALISE FERMENTE POUR LE MENU HORIZONTAL SAV
                    echo '</header>
                            <section>';
                }
            }

            public function footer() {
                ?>
            </aside>
            <footer>
                projet CNAM NFA 1.29 Stéphane NGOV
            </footer>
        </body>
        </html>
        <?php
    }

    public function chargePagePubilc() {//on charge les pages pubiques
        $page_public = array();
        $page_public[] = '../page/contact.php';
        $page_public[] = '../page/activite.php';
        $page_public[] = '../page/rapport.php';
        $this->page_public = $page_public;
    }

    public function seConnecter($connexion_start) {
        //********************** PAGE ACCUEIL  NON CONNECTE *************************
        //si pas de session membre, il faut invité à se connecté

        $_SESSION['obj_connexion'] = serialize($connexion_start); //on garde la session
        $test_identifiant = $connexion_start->getInformation();
        ?>
        <h1><?php echo $test_identifiant ?></h1>
        <form method="post" action="../membre/verif_connexion.php">
            identifiant (email):<input type="text" name="email"><br/>
            mot de passe <input type="password" name="password">     
            <input type="submit" value="envoyer">
        </form>
        <?php
    }

}

/*PROJET STEPHANE NGOV V1.38**/
?>
