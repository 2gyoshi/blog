<?php

require('./select.php');
require('./create_tags_json.php');

$file = "../sql/select_tags_data.sql";
$sql = file_get_contents($file);
$data = select($sql);
createTagsJson($data);

?>