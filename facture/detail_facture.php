<?php
//affiche la facture en fonction du numéro d'affaire
$resum_affaire = new Affaire($visiteur->getCrypt());
//RECHERCHE DES TECHNICIENS QUI SE SONT OCCUPE DE CETTE AFFAIRE
$charge_tech = $resum_affaire->chargeAffaireTech($id_affaire);

//RECHERCHE DU RECEPTIONNISTE DE CETTE AFFAIRE
$charge_recept = $resum_affaire->chargeAffaireRecept($id_affaire);

//RECHERCHE DES PIECES UTILISER
$resumer = $resum_affaire->resumAffaire($id_affaire);

//RECHERCHER DES INTERVENTIONS
$resum_inter = $resum_affaire->resumInter($id_affaire);

$piece_util = $resum_affaire->resumPiece($id_affaire);
?>

<table>
    <tr>
        <td id="en_charge">
            pris en charge par :
        </td>
        <td id="charge_tech">
            technicien(s) :
        </td>
        <td>reception :</td>
    </tr>
    <tr>
        <td>

        </td>
        <td>
            <?php
            foreach ($charge_tech as $C) {
                echo $C->nom . " - ";
            }
            ?>
        </td>
        <td>
            <?php echo $charge_recept->nom ?>

        </td>
    </tr>
</table>

<div class="client">
    <label> nom du client :</label> <?php echo $resumer->nom; ?><br/>
    <label>prenom: </label> <?php echo $resumer->prenom; ?><br/>
    <label>adresse : </label><?php echo $resumer->adresse; ?>  <br/>
    <label>telephone :</label> <?php echo $resumer->telephone; ?>  <br/>
    <label>courriel : </label><?php echo $resumer->email; ?>  <br/>
</div>

<table class="piece">
    <th>article</th><th>reference</th><th>quantite</th><th>prixHT</th>
    <?php
    $prix_piece = NULL;
    foreach ($piece_util as $P) {
        ?>
        <tr>
            <td><?php echo $P->nom_piece ?> </td>
            <td><?php echo $P->reference ?> </td>  
            <td><?php echo $P->quantite ?> </td>
            <td><?php echo $P->prixHT ?> </td>          

        </tr>
        <?php
        $prix_piece += $P->prixHT;
    }
    ?>
</table>


<table class="intervention">

        <th>date_inter</th><th>tache</th><th>duree en Heure</th>
    <?php
    $prix_inter = NULL;
    foreach ($resum_inter as $R) {
        ?>
        <tr>
            <td><?php echo $R->date_inter ?> </td>
            <td><?php echo $R->tache ?> </td>  
            <td><?php echo $R->duree ?> </td>
        </tr>
        <?php
        $prix_inter +=$R->duree;
    }
    ?>
</table>
