<?php

// sqlファイルを取得する
function get_sql_file_content($file){
    $path = "../sql";
    $sql = file_get_contents($path . "/" . $file);
    return $sql;
}

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

?>