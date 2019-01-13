<?php


class ArticleManager {
    
    public function addArticle($params = array()) {
        return DBWrapper::add('articles', $params);
    }

    public function getArticle($url) {
        return DBWrapper::getRow('
            SELECT `article_id`, `title`, `content`, `url`, `description`, `keywords`
            FROM `articles`
            WHERE `url` = ?
            ', array($url)
        );
    }

    public function getArticles() {
        return DBWrapper::getAllRows('
            SELECT `article_id`, `title`, `url`, `description`
            FROM `articles`
            ORDER BY `article_id` DESC
        ');
    }

    public function getMyArticles($id) {
        return DBWrapper::getAllRows('
            SELECT `article_id`, `title`, `url`, `description`
            FROM `articles`
            WHERE FK_user_id = ?
            ORDER BY `article_id` DESC
            ', array($id)
        );
    }

    public function saveArticle($id, $article) {
        if (!id) {
            DBWrapper::add('articles', $article);
        }
        else {
            DBWrapper::alter('articles', $article, 'WHERE article_id = ?', array($id));
        }
        DBWrapper::update('articles');
    }

    public function removeArticle($url) {
        DBWrapper::query('
                    DELETE FROM articles
                    WHERE url = ?
                    ', array($url)
        );
        DBWrapper::update('articles');
    }
}