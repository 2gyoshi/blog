INSERT INTO article_table
    (article_title, article_text, create_time, update_time, is_delete) 
VALUES 
    (@ARTICLE_TITLE, @ARTICLE_TEXT, NOW(), NOW(), 0);
