²+<?php
require_once '../lib/Ini.php';

class FormClient extends Form {

    private $id_client = NULL;

    public function __construct($cible, $titre_form) {
        $this->session_visiteur = $_SESSION['visiteur'];
        $ajouter_ou_modifier = $this->session_visiteur->getAjouterOrModifier();
        $this->openForm($cible, $titre_form); //balise form
        if ($ajouter_ou_modifier == 'A') {// si on est en mode ajouter on affiche le formulaire
            $this->submit = "Ajouter client";
            $this->formModifierClient();
        } else {//sinon on est en mode modifier on récupere le client à modifier
            $id_client = $this->session_visiteur->getMemNextAction();
            $this->id_client = $id_client;
            $this->submit = "modifier client";
            $this->hydrateFormClient();
        }
        //si erreur de formulaire , on hydrate les champs
        if ($this->session_visiteur->getPoster() != NULL) {

        }
    }

    public function hydrateFormClient() {
        //on recherche le membre
        $client = new Membre();
        $client->hydrateMembre($this->id_client);
        $attribut_client = $client->allAtribut();

        $this->email = $attribut_client['email'];
        $this->id_membre = $attribut_client['id_membre'];
        $this->nom = $attribut_client['nom'];
        $this->prenom = $attribut_client['prenom'];
        $this->adresse = $attribut_client['adresse'];
        $this->telephone = $attribut_client['telephone'];
        $this->formModifierClient();
    }

    public function formModifierClient() {
        $this->getSimpleFormMembre();
        $this->endForm($this->submit);
    }

}