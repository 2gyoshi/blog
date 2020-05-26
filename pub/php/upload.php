<?php

require(dirname(__FILE__)."/utility.php");

main();

function main() {
    $upload_dir = Utility::get_upload_dir();
    
    if(!isset($_FILES["files"])) {
        echo json_encode(Utility::get_response(0, true));
        return;
    }

    foreach ($_FILES["files"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["files"]["tmp_name"][$key];
            // basename() で、ひとまずファイルシステムトラバーサル攻撃は防げるでしょう。
            // ファイル名についてのその他のバリデーションも、適切に行いましょう。
            $name = basename($_FILES["files"]["name"][$key]);
            move_uploaded_file($tmp_name, "$upload_dir/$name");
        }
    }
    
    echo json_encode(Utility::get_response(0, true));

}

?>