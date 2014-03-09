<?php
require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
$start = new startIndex($visiteur, 1); //1 = menu application
//*************************************** PREPARTATION DE LA PAGE HTML + MENU PROJET STEPHANE NGOV****************************************
$html = new Html('recherche piece');
$html->headPlus('<link rel=stylesheet type="text/css" href="../public/css/stock.css">'); //ajouter le css admin
$html->banniere('recherche piece');
$html->navCategorie($start->getLienCategorie());
$menu = $start->getLienMenu();
$menu_courrant  = $start->filtreMenu($menu,"magasin");//filtre seulement menu de la page courrant
$html->navMenu($menu_courrant, 'menu_action'); //MENU ACTION LATTERAL GAUCHE
?>
<article>
    
<a href="#null" onclick="javascript:history.back();">Précédent</a>
    <?php
    $id_affaire = $visiteur->getMemNextAction();

    if ($id_affaire != NULL) {
        echo "<h1>déstocker la pièce pour affaire numéro:" . $id_affaire . "";
    }
    ?>
    <script type="text/javascript">
    <?php
    //préremplir la recherche de piece
    if (isset($_GET['motcle'])) {
        $motcle = $_GET['motcle'];
        ?>
        
            ajax("<?php echo $motcle ?>");
    <?php
}
?>  
        function ajax(motcle)
        {
            var xhr = null;
            if(window.XMLHttpRequest)  
            {
                xhr = new XMLHttpRequest();
            }
            else if(window.ActiveXObject)
            {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
    
            xhr.onreadystatechange = function(){recup_resultat(xhr);};
            xhr.open("GET","ajax.php?motcle="+motcle,true);
            xhr.send(null);
        }

        function recup_resultat(xhr)
        {
            if(xhr.readyState == 4)
            {
                document.getElementById("resultat").innerHTML = xhr.responseText;          
            }
        }

        function recupMotCle()
        {
            var motcle;
            motcle = document.getElementById("motcle").value;
            if(motcle.length > 2)
                {
            ajax(motcle);
                }
        }
    </script>
<?php
$recherche_piece = new FormRecherchePiece();
?>
<b>exemple rechercher : relais </b><br/> 
    <input id="motcle" type="text" value="" onkeyup="recupMotCle()" />

   <div id="resultat">  

    </div>
    <a href="../technique/fiche_intervention.php?id_affaire_tech=<?php echo $visiteur->getMemNextAction()."&crypt=" . $visiteur->getCrypt() ?>">revenir fiche affaire</a><br/>
</article>

</section>
<aside><!-- balise aside fermante dans le footer -->
    <div id="panier_piece">
    <?php
if (isset($_SESSION['panier'])) {
    echo '<h4>'.count($_SESSION['panier']) ?> pièce(s) on(t) été sélectionnée(s)</h4>
          </span><a href='voir_panier.php'> => valider et modifier la sélectionner</a>
        <?php
   
} else {
    $_SESSION['panier'] = array(); //creation de la session panier de piece
}
?>
</div>
    <?php
$html->footer();
?>
