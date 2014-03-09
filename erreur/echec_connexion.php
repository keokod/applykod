<?php
session_start();
unset($_SESSION['visiteur']);
session_unset($_SESSION);
session_destroy();
?>
<h1>Vos identifiant son toujour incorrecte, 
vous pouvez réintialiser vos identifiant ici par email</h1>

<a href="../public/index.php">page accueil</a>