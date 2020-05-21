<?php

function select($sql){
	$result = null;
	$pdo    = null;
	
	try {
		// DBへ接続する
		$host = "localhost";
		$db   = "blog";
		$user = "root";
		$pass = "root";
		$pdo  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);
	
		// クエリを実行する
		$result = $pdo->query($sql);
	} catch(PDOException $e) {
		echo $e->getMessage();
	} finally {
		// 接続を閉じる
		$pdo = null;
	}

	return $result;
}

?>