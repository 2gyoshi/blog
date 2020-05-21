SELECT
    a.article_id,
    a.article_title,
    a.article_text,
    ai.article_image,
    a.update_time
FROM article_table AS a
LEFT JOIN article_image_table AS ai
ON a.article_id = ai.article_id
WHERE a.is_delete <> 1
ORDER BY
    a.article_title,
    a.article_text,
    ai.article_image;