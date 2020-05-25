<?php

require('./utility.php');

main();

function main() {
    echo get_article_json();
}

class Article {
	public int $id = 0;
	public string $title = "";
	public string $text = "";
	public array $images = array();
	public array $tags = array();
	public string $time = "";

	function __construct($id, $title, $text, $image, $tag, $time) {
		$this->id = $id;
		$this->title = $title;
		$this->text = $text;
		array_push($this->images, $image);
		array_push($this->tags, $tag);
		$this->time = $time;
	}

	public function getID() {
		return $this->id;
	}

	public function pushImage($image) {
		foreach ($this->images as $value) {
			if($image === $value) return;
		}
		array_push($this->images, $image);
	}

	public function pushTag($tag) {
		foreach ($this->tags as $value) {
			if($tag === $value) return;
		}
		array_push($this->tags, $tag);
	}
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
        echo json_encode(get_api_result_failure($e->getMessage()));
    }
    
    return json_encode($result);
}

function get_article_data() {
    $result = null;
    $pdo = null;

    try {
        // DBへ接続する
		$config = get_db_config();
        $host = $config["host"];
        $db = $config["db"];
        $user = $config["user"];
		$pass = $config["pass"];
        $pdo  = new PDO("mysql:host=$host; dbname=$db;", $user, $pass);

        $file = get_select_sql_file_name("article");
        $sql = get_sql_file_content($file);

		// // クエリを実行する
        $result = $pdo->query($sql);

    } catch(PDOException $e) {
        echo json_encode(get_api_result_failure($e->getMessage()));
    } finally {
        // 接続を閉じる
        $pdo = null;
    }

    return $result;
}
?>