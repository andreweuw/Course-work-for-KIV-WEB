<?php

class ReviewsController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Editace uživatelských práv',
            'description' => 'Tato stránka je určena k editaci uživatelských práv jiných uživatlů.',
            'keywords' => 'editace, edit, uzivatele, users, admin, prava, status');

        $reviewManager = new ReviewManager();
        $reviews = $reviewManager->getReviews();
        $this->data['reviews'] = $reviews;
        $this->view = 'reviews';
    }
}