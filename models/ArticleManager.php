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

    public function getArticleById($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `articles` 
            WHERE `article_id` = ?
            ', array($id)
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

    public function uploadPdf($fileName, $fileTmpName) {
        $uploaddir = $_SERVER['DOCUMENT_ROOT']."/articles/";
        $uploadfile = $uploaddir . basename($fileName);

        echo '<pre>';
        if (move_uploaded_file($fileTmpName, $uploadfile)) {
            echo "File is valid, and was successfully uploaded.\n";
        } else {
            echo "Possible file upload attack!\n";
        }
    }

    public function downloadPdf($path) {
        if (file_exists($path)) {
            $file = $path;
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }

    public function saveArticle($title, $url, $abstract, $description, $keywords, $file_name) {
        $article = $this->getArticle($url);
        if ($article) {
            $this->deleteArticle($article['article_id']);
        }

        $articleController = new ArticleController();
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $article = array(
            'title' => $title,
            'abstract' => $abstract,
            'url' => $url,
            'description' => $description,
            'keywords' => $keywords,
            'status' => 'k recenzi',
            'FK_user_id' =>  $user['user_id'],
            'file_name' => $file_name
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

    public function deletePdf($fileName) {
        $directory = $_SERVER['DOCUMENT_ROOT']."/articles/";
        unlink($directory . $fileName);
    }
}