<?php

class ArticleList {
	public array $articles = array();

	public function getArticle($id) {
		$result = null;
		foreach($this->articles as $value) {
			if($value->getID() === $id) {
				$result = $value;
			}
		}
		return $result;
	}

	public function pushArticle($article) {
		array_push($this->articles, $article);
	}

	public function getArticles() {
		return $this->articles;
	}
}

class Article {
	public int $id = 0;
	public string $title = "no title";
	public string $text = "";
	public array $images = array();
	public string $time = "";

	function __construct($id, $title, $text, $image, $time) {
		$this->id = $id;
		$this->title = $title;
		$this->text = $text;
		array_push($this->images, $image);
		$this->time = $time;
	}

	public function getID() {
		return $this->id;
	}

	public function pushImage($image) {
		array_push($this->images, $image);
	}
}

function createArticleJson($stmt) {
	$result = [];
	
	try {
		
		$list = new ArticleList();
		
		while ($row = $stmt->fetch()) {
			$idh    = $stmt->getColumnMeta(0)["name"];
			$titleh = $stmt->getColumnMeta(1)["name"];
			$texth  = $stmt->getColumnMeta(2)["name"];
			$imageh = $stmt->getColumnMeta(3)["name"];
			$timeh  = $stmt->getColumnMeta(4)["name"];

			$id    = (int)$row[$idh];
			$title = $row[$titleh];
			$text  = $row[$texth];
			$image = $row[$imageh];
			$time  = $row[$timeh];

			$article = $list->getArticle($id);
			
			if($article !== null) {
				$article->pushImage($image);
			} else {
				$article = new Article($id, $title, $text, $image, $time);
				$list->pushArticle($article);
			}

		}
		echo json_encode($list);

	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
	return $result;
}

?>