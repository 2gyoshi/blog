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

function createArticleJson($stmt) {
	try {
		$list = new ArticleList();
		
		while ($row = $stmt->fetch()) {
			$idh    = $stmt->getColumnMeta(0)["name"];
			$titleh = $stmt->getColumnMeta(1)["name"];
			$texth  = $stmt->getColumnMeta(2)["name"];
			$imageh = $stmt->getColumnMeta(3)["name"];
			$tagh   = $stmt->getColumnMeta(4)["name"];
			$timeh  = $stmt->getColumnMeta(5)["name"];

			$id    = (int)$row[$idh];
			$title = $row[$titleh];
			$text  = $row[$texth];
			$image = $row[$imageh];
			$tag   = $row[$tagh];
			$time  = $row[$timeh];

			$article = $list->getArticle($id);
			
			if($article !== null) {
				$article->pushImage($image);
				$article->pushTag($tag);
			} else {
				$article = new Article($id, $title, $text, $image, $tag, $time);
				$list->pushArticle($article);
			}
		}
		echo json_encode($list);
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
}

?>