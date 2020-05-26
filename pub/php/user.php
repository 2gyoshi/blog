<?php

class User {
    public string $id = "";
    public string $password = "";

    public function setID($id) {
        $this->id= $id;
    }

    public function setPassword($password) {
        $this->password = $password;
    }
}

?>
