SELECT
    a.article_id,
    a.article_title,
    a.article_text,
    ai.article_image,
    at.article_tag,
    a.update_time
FROM article_table AS a
LEFT JOIN article_image_table AS ai
 ON a.article_id = ai.article_id
LEFT JOIN article_tag_table AS at
 ON a.article_id = at.article_id
WHERE a.is_delete <> 1
ORDER BY
    a.article_id;