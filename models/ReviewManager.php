<?php


class ReviewManager {
    
    public function addReview($params = array()) {
        return DBWrapper::add('reviews', $params);
    }

    public function getReview($url) {
        return DBWrapper::getRow('
            SELECT `review_id`, `title`, `content`, `url`, `description`, `keywords`
            FROM `reviews`
            WHERE `url` = ?
            ', array($url)
        );
    }

    public function assertReview() {
        return;
    }

    public function getReviews() {
        return DBWrapper::getAllRows('
            SELECT `review_id`, `score`, `lingvistic`
            FROM `reviews`
            ORDER BY `review_id` DESC
        ');
    }

    public function getMyReviews($id) {
        return DBWrapper::getAllRows('
            SELECT `review_id`, `score`, `lingvistic`
            FROM `reviews`
            WHERE reviewer_id = ?
            ORDER BY `review_id` DESC
            ', array($id)
        );
    }

    public function saveReview($id, $review) {
        if (!id) {
            DBWrapper::add('reviews', $review);
        }
        else {
            DBWrapper::alter('reviews', $review, 'WHERE review_id = ?', array($id));
        }
        DBWrapper::update('reviews');
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