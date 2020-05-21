<?php

function selectArticleData($id){
	$result = null;
	$pdo    = null;
	
	try {
		// DBへ接続
		$host = "localhost";
		$db   = "blog";
		$user = "root";
		$pass = "root";
		$pdo  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);
	
		// testテーブルの全データを取得
		$file = "../sql/select_article_data.sql";
		$sql = file_get_contents($file);
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