<?php
session_start();
session_unset($_SESSION);
session_destroy();
?>

<h1>! Action interdite, merci de revenir au menu, déconnexion de votre compte</h1>

<h2>Merci de recommencer</h2>

<a href="../public/index.php">aller à la page de connexion</a>