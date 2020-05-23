<?php

// TODO: とんでもなくコードが汚いので修正する
$params = json_decode(file_get_contents('php://input'), true);

$title  = $params["title"];
$text   = $params["text"];
$images = $params["images"];
$tags   = $params["tags"];

$result = null;
$dbh    = null;

try {
    // DBへ接続する
    $host = "localhost";
    $db = "blog";
    $user = "root";
    $pass = "root";
    $dbh  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);

    $file = "../sql/select_new_article_id.sql";
    $sql= file_get_contents($file);
    $stmt = $dbh->query($sql);
    $id= $stmt->fetch()["article_id"];

    $sql_place = [];

    // 記事テーブル
    $file = "../sql/insert_article_table.sql";
    $sql = file_get_contents($file);
    $sql = str_replace("@ARTICLE_TITLE", "'" . $title . "'", $sql);
    $sql = str_replace("@ARTICLE_TEXT", "'" . $text . "'", $sql);
    array_push($sql_place, $sql);

    // 画像テーブル
    $file = "../sql/insert_article_image_table.sql";
    foreach ($images as $value) {
        $sql = file_get_contents($file);
        $sql = str_replace("@ARTICLE_ID", $id, $sql);
        $sql = str_replace("@ARTICLE_IMAGE", "'" . $value . "'", $sql);
        array_push($sql_place, $sql);
    }

    // タグテーブル
    $file = "../sql/insert_article_tag_table.sql";
    $sql = file_get_contents($file);
    foreach ($tags as $value) {
        $sql = file_get_contents($file);
        $sql = str_replace("@ARTICLE_ID", $id, $sql);
        $sql = str_replace("@ARTICLE_TAG", "'" . $value . "'", $sql);
        array_push($sql_place, $sql);
    }

    $sql = "";
    foreach ($sql_place as $value) {
        $sql .= $value;
    }

    // クエリを実行する
    $dbh->beginTransaction();
    $dbh->exec($sql);
    $dbh->commit();

    echo json_encode([
        "status" => "sucsess",
        "message" => "Completion of registration"
    ]);

} catch(PDOException $e) {
    echo json_encode([
        "status" => "failure",
        "message" => $e->getMessage()
    ]);
    $dbh->rollBack();
} finally {
    // 接続を閉じる
    $dbh = null;
}



?>