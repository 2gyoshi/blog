INSERT INTO article_tag_table 
    (article_id, article_tag, create_time, update_time, is_delete)
VALUES
    (@ARTICLE_ID, @ARTICLE_TAG, NOW(), NOW(), 0);
