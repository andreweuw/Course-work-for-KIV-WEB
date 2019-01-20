<?php

/**
 * Třída pro zacházení s tabulkou 'reviews'
 */
class ReviewManager {
    
    /**
     * Přidá danou recenzi do tabulky
     */
    public function addReview($params = array()) {
        return DBWrapper::add('reviews', $params);
    }

    /**
     * Vrátí recenzi v závislosti na jejím url
     */
    public function getReview($url) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews`
            WHERE `url` = ?
            ', array($url)
        );
    }

    /**
     * Vrátí ohodnocení pro dané id článku
     */
    public function getScoreForArticle($article_id) {
        return DBWrapper::getRow('
            SELECT score 
            FROM `reviews` 
            WHERE `FK_article_id` = ?
            ', array($article_id)
        );
    }

    /**
     * Vrátí recenzi k danému článku
     */
    public function getReviewByArticle($article_id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `FK_article_id` = ?
            ', array($article_id)
        );
    }

    /**
     * Vrátí recenzi podle daného id recenze
     */
    public function getReviewById($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `review_id` = ?
            ', array($id)
        );
    }

    /**
     * Vrátí recenzi podle daného id recenzeta
     */
    public function getReviewByReviewer($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `reviewer_id` = ?
            ', array($id)
        );
    }

    /**
     * Vrátí všechny recenze z tabulky
     */
    public function getReviews() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `reviews`
            ORDER BY `review_id` DESC
        ');
    }

    /**
     * Vrátí všechny recenze daného id recenzenta
     */
    public function getMyReviews($id) {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `reviews`
            WHERE reviewer_id = ?
            ORDER BY `review_id` DESC
            ', array($id)
        );
    }

    /**
     * Vrátí id recenze, pokud tato recenze k danému článku exituje, null když ne
     */
    public function isFirstReview($article_id) {
        $old = $this->getReviewByArticle($article_id);
        if ($old) {
            return $old['review_id'];
        }
        return null;
    }

    /**
     * Vyzkouší, jestli recenze, kterou chceme přidat z parametru již v databázi existuje od jednoho samého uživatele
     * a popřípadě ji odstraníme.
     * Dále přidáme požadovanou recenzi do databáze
     */
    public function saveReview($review = array()) {
        $reviewController = new ReviewsController();
        $user = (new UserManager())->getUser();
        $review_2 = $this->getReviewByReviewer($review['reviewer_id']);

        if ($review_2) {
            if ($old = ($this->isFirstReview($review['FK_article_id'])) && 
                $review_2['FK_article_id'] == $review['FK_article_id']) {
                $this->deleteReview($old);
            }
        }

        try {
            DBWrapper::add('reviews', $review);
            $reviewController->addMessage('Recenze byla úspěšně uložena.');
        }
        catch (PDOException $error) {
            $reviewController->addMessage($error);
            $reviewController->addMessage('Recenze se nepodařila uložit.');
        }
    }

    /**
     * Odstraní recenzi na základě dané id recenze
     */
    public function deleteReview($id) {
        DBWrapper::query('
            DELETE FROM reviews
            WHERE review_id = ?
                ', array($id)
        );
    }
}