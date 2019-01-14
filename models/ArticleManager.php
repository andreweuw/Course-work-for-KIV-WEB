<?php

class ArticleManager {
    
    public function addArticle($params = array()) {
        return DBWrapper::add('articles', $params);
    }

    public function getArticle($url) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `articles` 
            WHERE `url` = ?
            ', array($url)
        );
    }

    public function getArticles() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `articles` 
            ORDER BY `article_id` DESC
        ');
    }

    public function getMyArticles($id) {
        return DBWrapper::getAllRows('
            SELECT * FROM `articles` 
            WHERE FK_user_id = ? 
            ORDER BY `article_id` DESC
            ', array($id)
        );
    }

    public function saveArticle($title, $pdf, $url, $abstract, $description, $keywords) {
        $articleController = new ArticleController();
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $article = array(
            'title' => $title,
            'pdf' => $pdf,
            'abstract' => $abstract,
            'url' => $url,
            'description' => $description,
            'keywords' => $keywords,
            'status' => 'k recenzi',
            'FK_user_id' =>  $user['user_id']
        );

        try {
            DBWrapper::add('articles', $article);
            $articleController->addMessage('Článek byl úspěšně uložen.');
        }
        catch (PDOException $error) {
            $articleController->addMessage($error);
            $articleController->addMessage('Článek s tímto názvem již existuje.');
        }
    }

    public function deleteArticle($id) {
        $controller = new UsersController();
        DBWrapper::query('
            DELETE FROM articles WHERE article_id = ? 
        ', array($id));
        $controller->addMessage('Článek s id '. $id . ' byl úspěšně odstraněn');
    }
}