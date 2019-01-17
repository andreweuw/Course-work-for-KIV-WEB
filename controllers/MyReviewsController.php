<?php

class MyReviewsController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Moje příspěvky',
            'description' => 'Tato stránka je určena k prohlédnutí příspěvků uživatele v roli autora.',
            'keywords' => 'prohlidnuti, autor, review, prispevek, prispevky');

        $reviewManager = new ReviewManager();
        $userManager = new UserManager();
        $articleManager = new ArticleManager();
        
        if (!empty($params[0]) && $params[0] == 'prepare') {
            $article_id = $params[1];
            $this->redirect('reviewEditor/prepare/' . $article_id);
        }
        else if(!empty($params[0]) && $params[0] == 'edit') {
            $article_id = $params[1];
            $this->redirect('reviewEditor/edit/' . $article_id);
        }
        else if(!empty($params[0]) && $params[0] == 'remove') {
            $article_id = $params[1];
            $this->redirect('reviewEditor/remove/' . $article_id);
        }

        $user = $userManager->getUser();
        $articles = $articleManager->getArticlesForReview($user['user_id']);
        $reviews = $reviewManager->getMyReviews($user['user_id']);

        
        $this->data['reviews'] = $reviews;
        $this->data['myArticles'] = $articles;
        $this->view = 'myReviews';
    }
}