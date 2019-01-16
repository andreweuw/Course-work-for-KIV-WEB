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

    public function getReviewById($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `reviews` 
            WHERE `review_id` = ?
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

    public function saveReview($id, $FK_review_id, $lingvistic, $notes, $score, $technical) {
        $reviewController = new ReviewsController();
        $user = (new UserManager())->getUser();
        $review = $this->getReviewById($id);
        if ($review) {
            $this->deletereview($review['review_id']);
        }

        $review = array(
            'FK_article_id' => $FK_review_id,
            'lingvistic' => $lingvistic,
            'notes' => $notes,
            'reviewer_id' => $user['user_id'],
            'score' => $score,
            'technical' => $technical
        );

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
}