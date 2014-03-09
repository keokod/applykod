<?php

require_once '../lib/Ini.php';
extract($_POST);
$verif = new Verif();
$verif->verifSimpleAnnuaire($_POST);
$verif->strMinMax($mdp, 4, 8, 'mot de passe'); //4 = minimum caractère 8 = max caractere
$verif->validMdp($mdp, $confirm_mdp);
if ($verif->getCollectErr() == NULL) {//si pas d'erreur se saisi on modifie le compte su
    $query = "UPDATE membre SET
            email=:email , mdp=:mdp,civilite=:civilite,
            nom=:nom, prenom=:prenom, telephone=:telephone,
             adresse=:adresse, suspendu=:suspendu, type_user=:type_user
              WHERE id=:id_membre";
    $bdd = Bdd::getIntance();
    $mdp=sha1($mdp);
    $qb = $bdd->prepare($query);
    $qb->bindValue(':civilite', $civilite, PDO::PARAM_INT);
    $qb->bindValue(':nom', $nom, PDO::PARAM_STR);
    $qb->bindValue(':prenom', $prenom, PDO::PARAM_STR);
    $qb->bindValue(':telephone', $telephone, PDO::PARAM_INT);
    $qb->bindValue(':adresse', $adresse, PDO::PARAM_STR);
    $qb->bindValue(':email', $email, PDO::PARAM_STR);
    $qb->bindValue(':mdp', $mdp, PDO::PARAM_STR);
    $qb->bindValue(':suspendu', 0, PDO::PARAM_INT); //0 ou 1
    $qb->bindValue(':type_user', 'SU', PDO::PARAM_STR); //SU,client,technicien,magasinier,receptionnste
    $qb->bindValue(':id_membre', 1, PDO::PARAM_INT);
    $qb->execute();
    $force_auth = new Autorise();
    $force_auth->ajouterAuth(1, array('FF')); //on demande de modifier XX en FF;
    
} 

?>
<h1>Modification su SU terminer, merci de vous connecter <a href="../public/index.php">page accueil</a>
