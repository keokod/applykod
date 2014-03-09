<?php

class Jeton {

    private $crypt;
    private $token = array();

    public function __construct() {
        $crypt = sha1(uniqid(rand(), true));
        $this->crypt = $crypt;
        $this->token['crypt'] = $this->crypt;
        $this->token['time_create'] = time();
    }

    public function getToken() {//on crée une session token
        return $this->token;
    }

    public function kill($token) {
        unset($token);
    }

    public function __destruct() {
        $this->crypt = NULL;
        $this->token = NULL;
    }

}

?>
