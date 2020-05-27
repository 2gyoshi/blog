<?php

class User {
    public $id = "";
    public $password = "";

    public function setID($id) {
        $this->id= $id;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}

?>
