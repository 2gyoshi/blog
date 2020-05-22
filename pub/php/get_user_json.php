<?php

require('./select.php');

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

$id = "id";
$password = "password";
$file = "../sql/select_user.sql";

$list = array();
$sql = file_get_contents($file);
$stmt = select($sql);

while ($row = $stmt->fetch()) {
    $user = new User();
    $user->setID($row[$id]);
    $user->setPassword($row[$password]);
    array_push($list, $user);
}

echo json_encode($list);

?>
