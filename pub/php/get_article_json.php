<?php

require('./select_article_data.php');
require('./create_article_json.php');

$id = "";
if(isset($_GET["id"])) {
	$id = $_GET["id"];
}

$data = selectArticleData($id);
createArticleJson($data);

?>