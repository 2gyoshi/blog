<?php

require(dirname(__FILE__)."/utility.php");
require(dirname(__FILE__)."/user.php");

main();

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
    } catch(Exception $e) {
        echo json_encode(Utility::get_responce(-1, $e->getMessage()));
    }

    return json_encode($result);
}

function get_user_data() {
    $result = null;
    $pdo = null;

    try {
        // DBへ接続する
		$config = Utility::get_db_config();
        $host = $config["host"];
        $db = $config["db"];
        $user = $config["user"];
		$pass = $config["pass"];
        $pdo  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);

        $file = Utility::get_select_sql_file_name("user");
        $sql = Utility::get_sql_file_content($file);
    
		// // クエリを実行する
        $result = $pdo->query($sql);

    } catch(PDOException $e) {
        echo json_encode(Utility::get_responce(-1, $e->getMessage()));
    } finally {
        // 接続を閉じる
        $pdo = null;
    }

    return $result;
}

?>
