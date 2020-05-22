<?php

// TODO: とんでもなくコードが汚いので修正する

$title = "'" . $_POST["title"] . "'";
$image = "'" . $_POST["image"] . "'";
$text  = "'" . $_POST["text"] . "'";
$tag   = "'" . $_POST["tag"] . "'";

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
    $sql = str_replace("@ARTICLE_TITLE", $title, $sql);
    $sql = str_replace("@ARTICLE_TEXT", $text, $sql);
    array_push($sql_place, $sql);

    // 画像テーブル
    $file = "../sql/insert_article_image_table.sql";
    $image = [$image];
    foreach ($image as $value) {
        $sql = file_get_contents($file);
        $sql = str_replace("@ARTICLE_ID", $id, $sql);
        $sql = str_replace("@ARTICLE_IMAGE", $value, $sql);
        array_push($sql_place, $sql);
    }

    // タグテーブル
    $file = "../sql/insert_article_tag_table.sql";
    $sql = file_get_contents($file);
    $tag = [$tag];
    foreach ($tag as $value) {
        $sql = file_get_contents($file);
        $sql = str_replace("@ARTICLE_ID", $id, $sql);
        $sql = str_replace("@ARTICLE_TAG", $value, $sql);
        array_push($sql_place, $sql);
    }

    $sql = "";
    foreach ($sql_place as $value) {
        $sql .= $value;
    }

    echo $sql;

    // // クエリを実行する
    $dbh->beginTransaction();
    $dbh->exec($sql);
    $dbh->commit();

} catch(PDOException $e) {
    echo $e->getMessage();
    $dbh->rollBack();
} finally {
    // 接続を閉じる
    $dbh = null;
}



?>