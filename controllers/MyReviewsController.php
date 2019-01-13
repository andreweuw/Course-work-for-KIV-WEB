<?php

class MyReviewsController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Moje příspěvky',
            'description' => 'Tato stránka je určena k prohlédnutí příspěvků uživatele v roli autora.',
            'keywords' => 'prohlidnuti, autor, review, prispevek, prispevky');

        $articleManager = new ArticleManager();
        $articles = $articleManager->getMyArticles($this->data['user_id']);
        $this->data['articles'] = $articles;
        $this->view = 'articles';
    }
}