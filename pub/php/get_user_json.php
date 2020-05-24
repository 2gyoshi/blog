<?php

require('./utility.php');

main();

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

function main() {
    echo get_user_json();
}

function get_user_json() {
    $result = array();
    try {
        $col_id = "id";
        $col_password = "password";

        // // クエリを実行する
        $stmt = get_user_data();
        while ($row = $stmt->fetch()) {
            $user = new User();
            $user->setID($row[$col_id]);
            $user->setPassword($row[$col_password]);
            array_push($result, $user);
        }
    } catch(PDOException $e) {
        echo json_encode(get_api_result_failure($e->getMessage()));
    }

    return json_encode($result);
}

function get_user_data() {
    $result = null;
    $pdo = null;

    try {
        // DBへ接続する
        $host = "localhost";
        $db = "blog";
        $user = "root";
        $pass = "root";
        $pdo  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);

        $sql = get_select_sql();

		// // クエリを実行する
        $result = $pdo->query($sql);

    } catch(PDOException $e) {
        echo json_encode(get_api_result_failure($e->getMessage()));
    } finally {
        // 接続を閉じる
        $pdo = null;
    }

    return $result;
}

function get_select_sql() {
    $file = get_select_sql_file_name("user");
    $sql = get_sql_file_content($file);
    return $sql;
}


?>
