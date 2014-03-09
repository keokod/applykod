<?php 
require_once '../lib/Ini.php'; //MENU APPLICATION PRINCIPAL
$visiteur = $_SESSION['visiteur'];
header("Content-Type: text/plain");
$bdd = Bdd::getIntance();
$motcle = $_GET['motcle'];
$query = 'SELECT *  FROM  stock WHERE  nom_piece  LIKE "%'.$motcle.'%" ';
$prep = $bdd->prepare($query);
$prep->bindValue(':motcle', $motcle, PDO::PARAM_STR);
$prep->execute();
$data = $prep->fetchAll();
//on mémorise les résultats trouvé


?>
<table>
    <th>quantite en stock</th><th>nom de la piece</th><th>reference</th><th>quantite</th><th>destocker</th>
<?php
foreach($data as $D)
{
?>
    <tr>
    <td> <?php echo $D['quantite']; ?> </td>  
    <td> <?php echo $D['nom_piece']; ?> </td>
    <td> <?php echo $D['reference']; ?> </td>
    <td> <?php echo $D['quantite']; ?> </td>
    <td><a href="ajouter_panier.php?id_piece=<?php echo $D['id'] ?>&motcle=<?php echo $motcle ?>"> + panier</a></td>  
    </tr>
    <?php
   
}
?>
</table>

