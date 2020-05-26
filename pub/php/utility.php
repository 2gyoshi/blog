<?php

class Utility {
    // APIのレスポンスを取得する
    public static function get_response($status, $result) {
        $response = [
            "status" => $status,
            "result" => $result
        ];
        return $response;
    } 

    // sqlファイルを取得する
    public static function get_sql_file_content($file_name){
        $root_dir = $_SERVER["DOCUMENT_ROOT"];
        $sql_dir = "$root_dir/dev/blog/pub/sql";
        $file = "$sql_dir/$file_name";
        $sql = file_get_contents($file);
        return $sql;
    }

    // TODO: 統合する
    // sqlファイル名を取得する
    public static function get_select_sql_file_name($value) {
        $file = "";
        switch ($value) {
            case 'article':
                $file = "select_article_data.sql";
                break;
            case 'user':
                $file = "select_user.sql";
                break;
            case 'article_id':
                $file = "select_new_article_id.sql";
                break;
            default:
                break;
        }
        return $file;
    }

    // TODO: 統合する
    // sqlファイル名を取得する
    public static function get_insert_sql_file_name($value) {
        $file = "";
        switch ($value) {
            case 'article':
                $file = "insert_article_table.sql";
                break;
            case 'image':
                $file = "insert_article_image_table.sql";
                break;
            case 'tag':
                $file = "insert_article_tag_table.sql";
                break;
            default:
                break;
        }
        return $file;
    }

    // データベースの設定を取得する
    public static function get_db_config() {
        $config = [
            "host" => "localhost",
            "db" => "blog",
            "user" => "root",
            "pass" => "root"
        ];
        return $config;
    }

    // 記事画像のアップロード先を取得する
    public static function get_upload_dir() {
        $root_dir = $_SERVER["DOCUMENT_ROOT"];
        $upload_dir = "$root_dir/dev/blog/pub/img/article";
        return $upload_dir;
    }
}


?>