<?php

function get_api_result_sucsess() {
    $code_sucsess = 0;
    $ms_success = "sucsess!";
    $result = [
        "status" => $code_sucsess,
        "message" => $ms_success
    ];
    return $result;
}

function get_api_result_failure($message) {
    $code_failure = -1;
    $result = [
        "status" => $code_failure,
        "message" => $message
    ];
    return $result;
}

// sqlファイルを取得する
function get_sql_file_content($file){
    $path = "../sql";
    $sql = file_get_contents($path . "/" . $file);
    return $sql;
}

function get_select_sql_file_name($value) {
    $file = "";
    switch ($value) {
        case 'article_id':
            $file = "select_new_article_id.sql";
            break;
        case 'user':
            $file = "select_user.sql";
            break;
        default:
            break;
    }
    return $file;
}

function get_insert_sql_file_name($value) {
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


?>