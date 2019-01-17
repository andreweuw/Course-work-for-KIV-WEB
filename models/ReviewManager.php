<?php


class ReviewManager {
    
    public function addReview($params = array()) {
        return DBWrapper::add('reviews', $params);
    }

    public function getReview($url) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews`
            WHERE `url` = ?
            ', array($url)
        );
    }

    public function getScoreForArticle($article_id) {
        return DBWrapper::getRow('
            SELECT score 
            FROM `reviews` 
            WHERE `FK_article_id` = ?
            ', array($article_id)
        );
    }

    public function getReviewByArticle($article_id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `FK_article_id` = ?
            ', array($article_id)
        );
    }

    public function getReviewById($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `review_id` = ?
            ', array($id)
        );
    }

    public function getReviewByReviewer($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `reviewer_id` = ?
            ', array($id)
        );
    }

    public function getReviews() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `reviews`
            ORDER BY `review_id` DESC
        ');
    }

    public function getMyReviews($id) {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `reviews`
            WHERE reviewer_id = ?
            ORDER BY `review_id` DESC
            ', array($id)
        );
    }

    public function isFirstReview($article_id) {
        $old = $this->getReviewByArticle($article_id);
        if ($old) {
            return $old['review_id'];
        }
        return null;
    }

    public function saveReview($review = array()) {
        $reviewController = new ReviewsController();
        $user = (new UserManager())->getUser();

        if ($old = ($this->isFirstReview($review['FK_article_id']))) {
            $this->deleteReview($old);
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


    public function removeReview($url) {
        DBWrapper::query('
                    DELETE FROM reviews
                    WHERE url = ?
                    ', array($url)
        );
        DBWrapper::update('reviews');
    }

    public function deleteReview($id) {
        DBWrapper::query('
            DELETE FROM reviews
            WHERE review_id = ?
                ', array($id)
        );
    }
}