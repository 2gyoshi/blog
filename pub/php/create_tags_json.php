<?php

class TagList {
	public array $items = array();

	public function pushItem($item) {
		array_push($this->items, $item);
	}

	public function getItems() {
		return $this->items;
	}
}

class Tag {
	public string $value = "";

	function __construct($value) {
		$this->value = $value;
	}

	function getValue() {
		return $this->value;
	} 
}

function createTagsJson($stmt) {
	try {
		$list = new TagList();
		
		while ($row = $stmt->fetch()) {
			$column = $stmt->getColumnMeta(0)["name"];
			$value  = $row[$column];

			$tag = new Tag($value);
			$list->pushItem($tag);
		}

		echo json_encode($list);
	}
	catch(Exception $e) {
		echo $e->getMessage();
	}
}

?>