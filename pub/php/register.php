<?php

require(dirname(__FILE__)."/utility.php");

main();

function main() {
    $dbh = null;

    try {
        // DBへ接続する
		$config = Utility::get_db_config();
        $host = $config["host"];
        $user = $config["user"];
		$pass = $config["pass"];
        $dbh  = new PDO($host, $user, $pass);

        $sql = get_insert_sql($dbh);

        // クエリを実行する
        $dbh->beginTransaction();
        $dbh->exec($sql);
        $dbh->commit();

        echo json_encode(Utility::get_response(0, true));

    } catch(PDOException $e) {
        echo json_encode(Utility::get_responce(-1, $e->getMessage()));
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
// TODO: アクティブな記事が0件のとき取得できないバグを修正したい
function get_article_id($dbh) {
    $file = Utility::get_select_sql_file_name("article_id");
    $sql = Utility::get_sql_file_content($file);

    $stmt = $dbh->query($sql);
    $id = $stmt->fetch()["article_id"];

    return $id;
}

// 記事テーブルに登録するクエリを取得する
function get_insert_sql_article($title, $text) {
    $file = Utility::get_insert_sql_file_name("article");
    $sql = Utility::get_sql_file_content($file);

    $sql = str_replace("@ARTICLE_TITLE", "'" . $title . "'", $sql);
    $sql = str_replace("@ARTICLE_TEXT", "'" . $text . "'", $sql);

    return $sql;
}

// 画像テーブルに登録するクエリを取得する
function get_insert_sql_image($id, $images) {
    $file = Utility::get_insert_sql_file_name("image");
    $sql = Utility::get_sql_file_content($file);

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
    $file = Utility::get_insert_sql_file_name("tag");
    $sql = Utility::get_sql_file_content($file);

    $sql_place = [];

    foreach ($tags as $value) {
        $tmp = str_replace("@ARTICLE_ID", $id, $sql);
        $tmp = str_replace("@ARTICLE_TAG", "'" . $value . "'", $tmp);
        array_push($sql_place, $tmp);
    }

    return implode($sql_place);
}

?>