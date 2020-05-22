INSERT INTO article_image_table
    (article_id, article_image, create_time, update_time, is_delete)
VALUES
    (@ARTICLE_ID, @ARTICLE_IMAGE, NOW(), NOW(), 0);
