<?php

require('./select.php');
require('./create_article_json.php');

$file = "../sql/select_article_data.sql";
$sql = file_get_contents($file);
$data = select($sql);
createArticleJson($data);

?>