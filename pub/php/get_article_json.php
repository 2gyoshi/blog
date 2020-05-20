<?php

require('./select_article_data.php');
require('./create_article_json.php');

$stmt = selectArticleData();
createArticleJson($stmt);

?>