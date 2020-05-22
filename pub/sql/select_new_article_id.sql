SELECT
    MAX(article_id) + 1 AS article_id
FROM article_table
WHERE is_delete <> 1;