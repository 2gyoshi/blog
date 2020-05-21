<?php

require('./select_article_data.php');
require('./create_article_json.php');

$data = selectArticleData();
createArticleJson($data);

?>