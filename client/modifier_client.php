<?php
require_once '../lib/Ini.php';//MODIFIER LE CLIENT VIA RECEPTIONNISTE
extract($_GET);
if(isset($id_client) && isset($crypt))
{
    $form_client = new FormClient('../reception/verif_saisie_affaire.php','modifier le client',$id_client);
    $form_client->getSimpleFormMembre();
}
 else {

}

?>