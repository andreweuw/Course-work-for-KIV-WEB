<?php

/**
 * Třída pro zacházení s tabulkou 'articles'
 */
class ArticleManager {
    
    /**
     * Přidá článek
     */
    public function addArticle($params = array()) {
        return DBWrapper::add('articles', $params);
    }

    /**
     * Vrátí článek podle dané url adresy
     */
    public function getArticle($url) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `articles` 
            WHERE `url` = ?
            ', array($url)
        );
    }

    /**
     * Vrátí článek podle daného id článku
     */
    public function getArticleById($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `articles` 
            WHERE `article_id` = ?
            ', array($id)
        );
    }

    /**
     * Vrátí všechny články z tabulky
     */
    public function getArticles() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `articles` 
            ORDER BY `article_id` DESC
        ');
    }

    /**
     * Vrátí všechny ty články, které byly zveřejněny.
     */
    public function getAllPublished() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `articles` 
            WHERE published = 1 
            ORDER BY `article_id` DESC
            ');
    }

    /**
     * Vrátí všechny články uživatele s daným id uživatele
     */
    public function getMyArticles($id) {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `articles` 
            WHERE FK_user_id = ? 
            ORDER BY `article_id` DESC
            ', array($id)
        );
    }

    /**
     * Vrátí největší počet recenzentů ze všech článků
     */
    public function getMaxRev() {
        return DBWrapper::getRow('
            SELECT MAX(reviewer_count) 
            as max 
            FROM articles;');
    }

    /**
     * Nahraje daný pdf soubor do podadresáře /articles/
     */
    public function uploadPdf($fileName, $fileTmpName) {
        $uploaddir = $_SERVER['DOCUMENT_ROOT']."/articles/";
        $uploadfile = $uploaddir . basename($fileName);
        move_uploaded_file($fileTmpName, $uploadfile);
    }

    /**
     * Nastaví artibut 'published' daného článku na hodnotu 'true'
     */
    public function setPublished($id) {
        $nextRank = true;
        DBWrapper::query("UPDATE articles SET `published` = ? WHERE article_id = ?", array($nextRank, $id));
    }

    /**
     * Stáhne uživateli soubor pdf z dané cesty pomocí protokolu FTP na lokální úložiště uživatele
     */
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

    /**
     * Zvýší stav článku.
     */
    public function raiseState($id) {
        $article = DBWrapper::getRow('
            SELECT * 
            FROM articles 
            WHERE article_id = ?
            ', array($id)
        );
        
        $status = $article['status'];
        if ($status == 'k recenzi') {
            $nextRank = 'čeká na rozhodnutí administrátora';
        } else if ($status == 'čeká na rozhodnutí administrátora') {
            $nextRank = 'schváleno';
        }
        if ($nextRank) {
            DBWrapper::query("UPDATE articles SET `status` = ? WHERE article_id = ?", array($nextRank, $id));
        }
    }

    /**
     * Sníží stav článku
     */
    public function lowerState($id) {
        $article = DBWrapper::getRow('
            SELECT * 
            FROM articles 
            WHERE article_id = ?
            ', array($id)
        );
        $nextRank = null;
        $status = $article['status'];
        if ($status == 'čeká na rozhodnutí administrátora') {
            $nextRank = 'k recenzi';
        }
        if ($nextRank) {
            DBWrapper::query("UPDATE articles SET `status` = ? WHERE article_id = ?", array($nextRank, $id));
        }
    }
    
    /**
     * Aktualizuje danému článku atributy 'reviewers_ids' a 'reviewer_count' na základě hodnot předaného pole $reviewers
     */
    public function updateReviewers($reviewers = array(), $count, $id) {
        $reviewers_ids = $reviewers[0];
        // Pouze pro výpis
        $articleController = new ArticleController();
        foreach(array_slice($reviewers, 1) as $reviewer) {
            $reviewers_ids .= ("_" . $reviewer);
        }

        // výpis recenzentů končí prázdným recenzentem
        if (substr($reviewers_ids, -1) === "_") {
            $articleController->addMessage("Musíte nejdříve vybrat nového nebo odebrat prázdnou kolonku pro recenzenta.");
        }
        else {
            DBWrapper::query("UPDATE articles SET `reviewers_ids` = ? WHERE article_id = ?", array($reviewers_ids, $id));
            DBWrapper::query("UPDATE articles SET `reviewer_count` = ? WHERE article_id = ?", array($count, $id));
            $articleController->addMessage("Recenzenti byli úspěšně přiřazeni ke článku.");
        }
    }

    /**
     * Zvýší hodnotu 'reviewer_count' v tabulce článků danému článku o 1, nebo -1 v závislosti na parametru $plus
     */
    public function updateRevCount($id, $plus) {
        $article = $this->getArticleById($id);
        $new = $article['reviewer_count'];
        if ($plus == true) {
            $new++;
        }
        else {
            $new--;
        }
        DBWrapper::query("UPDATE articles SET `reviewer_count` = ? WHERE article_id = ?", array($new, $id));
    }

    /**
     * Vrátí abstract daného článku v závislosti na jeho id
     */
    public function getAbstract($id) {
        return DBWrapper::getAllRows("
            SELECT abstract 
            FROM `articles` 
            WHERE article_id = ?", array($id)
        );
    }

    /**
     * Uloží daný článek do databáze, přehlednější způsob předání parametrů by byl polem!
     * Pokud takový článek již existuje, vymaže se a přidá se tento, nový
     */
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
            $articleController->addMessage('Článek s tímto názvem již existuje.');
        }
    }

    /**
     * Vymaže článek z databáze na základě jeho id
     */
    public function deleteArticle($id) {
        DBWrapper::query('
            DELETE FROM articles WHERE article_id = ? 
        ', array($id));
    }

    /**
     * Vymaže článek z lokálního serveru, podadresáře /articles/
     */
    public function deletePdf($fileName) {
        $directory = $_SERVER['DOCUMENT_ROOT']."/articles/";
        unlink($directory . $fileName);
    }

    /**
     * Vrátí všechny články, které obsahují dané id jako podřetězec atributu 'reviewers_ids'
     */
    public function getArticlesForReview($id) {
        return DBWrapper::getAllRows("
            SELECT * 
            FROM `articles` 
            WHERE reviewers_ids REGEXP ?", array($id)
        );
    }
}