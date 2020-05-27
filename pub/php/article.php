<?php

class Article {
	public $id = 0;
	public $title = "";
	public $text = "";
	public $images = array();
	public $tags = array();
	public $time = "";

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

?>
