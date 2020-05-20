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
	public array $image = array();

	function __construct($id, $title, $text, $image) {
		$this->id = $id;
		$this->title = $title;
		$this->text = $text;
		array_push($this->image, $image);
	}

	public function getID() {
		return $this->id;
	}

	public function pushImage($image) {
		array_push($this->image, $image);
	}
}

function createArticleJson($stmt) {
	$result = [];
	
	try {
		
		$stmt = selectArticleData();
		$list = new ArticleList();
		
		while ($row = $stmt->fetch()) {
			$idh    = $stmt->getColumnMeta(0)["name"];
			$titleh = $stmt->getColumnMeta(1)["name"];
			$texth  = $stmt->getColumnMeta(2)["name"];
			$imageh = $stmt->getColumnMeta(3)["name"];

			$id    = (int)$row[$idh];
			$title = $row[$titleh];
			$text  = $row[$texth];
			$image = $row[$imageh];

			$article = $list->getArticle($id);
			
			if($article !== null) {
				$article->pushImage($image);
			} else {
				$article = new Article($id, $title, $text, $image);
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