<?php

require('./utility.php');

main();

function main() {
    echo get_tag_json();
}

class Tag {
	public string $value = "";

	function __construct($value) {
		$this->value = $value;
	}

	function getValue() {
		return $this->value;
	} 
}

function get_tag_json() {
    $result = array();
    
    try {
        $stmt = get_tag_data();
		while ($row = $stmt->fetch()) {
			$column = $stmt->getColumnMeta(0)["name"];
			$value  = $row[$column];

            $tag = new Tag($value);
            array_push($result, $tag);
		}
	}
	catch(Exception $e) {
        echo json_encode(get_api_result_failure($e->getMessage()));
    }
    
    return json_encode($result);
}

function get_tag_data() {
    $result = null;
    $pdo = null;

    try {
        // DBへ接続する
        $host = "localhost";
        $db = "blog";
        $user = "root";
        $pass = "root";
        $pdo  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);

        $file = get_select_sql_file_name("tag");
        $sql = get_sql_file_content($file);

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

?>