CREATE TABLE article_table (
    article_id    int UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    article_title varchar(100),
    article_text  text,
    create_time   datetime,
    update_time   datetime,
    is_delete     bool
);

CREATE TABLE article_image_table (
    image_id      int UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
    article_id    int UNSIGNED NOT NULL,
    article_image varchar(100),
    create_time   datetime,
    update_time   datetime,
    is_delete     bool,
    CONSTRAINT fk_article_id_image
        FOREIGN KEY (article_id) 
        REFERENCES article_table (article_id)
        ON DELETE RESTRICT ON UPDATE RESTRICT
);

-- CREATE TABLE article_text (
--     text_id      int UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
--     article_id   int UNSIGNED NOT NULL,
--     article_text text,
--     create_time  datetime,
--     update_time  datetime,
--     is_delete    bool,
--     CONSTRAINT fk_article_text
--     FOREIGN KEY (article_id) 
--         REFERENCES article (article_id)
--         ON DELETE RESTRICT ON UPDATE RESTRICT
-- );