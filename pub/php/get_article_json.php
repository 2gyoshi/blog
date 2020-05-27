<?php

require(dirname(__FILE__)."/utility.php");
require(dirname(__FILE__)."/article.php");

main();

function main() {
    echo get_article_json();
}

function get_article_json() {
    $result = array();
    
    try {
        $col_id = "article_id";
		$col_title = "article_title";
		$col_text = "article_text";
		$col_image = "article_image";
		$col_tag = "article_tag";
		$col_time = "update_time";

        $stmt = get_article_data();
        while ($row = $stmt->fetch()) {
			$id    = (int)$row[$col_id];
			$title = $row[$col_title];
			$text  = $row[$col_text];
			$image = $row[$col_image];
			$tag   = $row[$col_tag];
			$time  = $row[$col_time];

            $article = null;
            foreach ($result as $value) {
                if($value->getID() !== $id) continue;
                $article = $value;
            }
			
			if($article !== null) {
				$article->pushImage($image);
				$article->pushTag($tag);
			} else {
				$article = new Article($id, $title, $text, $image, $tag, $time);
				array_push($result, $article);
			}
		}
	} catch(Exception $e) {
        echo json_encode(Utility::get_responce(-1, $e->getMessage()));
    }
    
    return json_encode($result);
}

function get_article_data() {
    $result = null;
    $dbh = null;

    try {
        // DBへ接続する
		$config = Utility::get_db_config();
        $host = $config["host"];
        $user = $config["user"];
		$pass = $config["pass"];
        $dbh  = new PDO($host, $user, $pass);

        $file = Utility::get_select_sql_file_name("article");
        $sql = Utility::get_sql_file_content($file);

		// // クエリを実行する
        $result = $dbh->query($sql);

    } catch(PDOException $e) {
        echo json_encode(Utility::get_responce(-1, $e->getMessage()));
    } finally {
        // 接続を閉じる
        $dbh = null;
    }

    return $result;
}

?>