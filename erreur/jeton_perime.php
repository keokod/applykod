<?php
session_start();
session_unset($_SESSION);
session_destroy();

?>
<h1>votre session est terminé, merci de vous reconnecter</h1>
<a href="../public/index.php">page accueil</a>