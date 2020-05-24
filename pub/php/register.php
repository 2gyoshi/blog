<?php

require('./utility.php');

main();

function main() {
    $dbh = null;

    try {
        // DBへ接続する
        $host = "localhost";
        $db = "blog";
        $user = "root";
        $pass = "root";
        $dbh  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);

        $sql = get_insert_sql($dbh);

        // クエリを実行する
        $dbh->beginTransaction();
        $dbh->exec($sql);
        $dbh->commit();

        echo json_encode(get_api_result_sucsess());
    } catch(PDOException $e) {
        echo json_encode(get_api_result_failure($e->getMessage()));
        $dbh->rollBack();
    } finally {
        // 接続を閉じる
        $dbh = null;
    }
}

function get_insert_sql($dbh) {
    // postされたデータを展開する
    $params = json_decode(file_get_contents('php://input'), true);
    $title  = $params["title"];
    $text   = $params["text"];
    $images = $params["images"];
    $tags   = $params["tags"];

    $id = get_article_id($dbh);
    $sql = get_insert_sql_article($title, $text);
    $sql .= get_insert_sql_image($id, $images);
    $sql .= get_insert_sql_tag($id, $tags);

    return $sql;
}

// 記事IDを取得する
function get_article_id($dbh) {
    $file = get_select_sql_file_name("article_id");
    $sql = get_sql_file_content($file);

    $stmt = $dbh->query($sql);
    $id = $stmt->fetch()["article_id"];

    return $id;
}

// 記事テーブルに登録するクエリを取得する
function get_insert_sql_article($title, $text) {
    $file = get_insert_sql_file_name("article");
    $sql = get_sql_file_content($file);

    $sql = str_replace("@ARTICLE_TITLE", "'" . $title . "'", $sql);
    $sql = str_replace("@ARTICLE_TEXT", "'" . $text . "'", $sql);

    return $sql;
}

// 画像テーブルに登録するクエリを取得する
function get_insert_sql_image($id, $images) {
    $file = get_insert_sql_file_name("image");
    $sql = get_sql_file_content($file);

    $sql_place = [];

    foreach ($images as $value) {
        $tmp = str_replace("@ARTICLE_ID", $id, $sql);
        $tmp = str_replace("@ARTICLE_IMAGE", "'" . $value . "'", $tmp);
        array_push($sql_place, $tmp);
    }

    return implode($sql_place);
}

// タグテーブルに登録するクエリを取得する
function get_insert_sql_tag($id, $tags) {
    $file = get_insert_sql_file_name("tag");
    $sql = get_sql_file_content($file);

    $sql_place = [];

    foreach ($tags as $value) {
        $tmp = str_replace("@ARTICLE_ID", $id, $sql);
        $tmp = str_replace("@ARTICLE_TAG", "'" . $value . "'", $tmp);
        array_push($sql_place, $tmp);
    }

    return implode($sql_place);
}

?>