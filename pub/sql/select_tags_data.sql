SELECT DISTINCT
    article_tag
FROM article_tag_table
WHERE is_delete <> 1
ORDER BY
    article_tag;
