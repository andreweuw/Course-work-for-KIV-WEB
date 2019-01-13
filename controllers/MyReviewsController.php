<?php

class MyReviewsController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Moje příspěvky',
            'description' => 'Tato stránka je určena k prohlédnutí příspěvků uživatele v roli autora.',
            'keywords' => 'prohlidnuti, autor, review, prispevek, prispevky');

        $reviewManager = new ReviewManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $reviews = $reviewManager->getMyReviews($user['user_id']);
        $this->data['reviews'] = $reviews;
        $this->view = 'myReviews';
    }
}