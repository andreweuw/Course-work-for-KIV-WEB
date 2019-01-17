<?php

class ReviewController extends Controller {

    public function process($params) {
        $reviewManager = new ReviewManager();
        $userManager = new UserManager();
        $articleManager = new ArticleManager();
        
        if (!empty($params[0])) {
            $review = $reviewManager->getReviewById($params[0]);
            $article = $articleManager->getArticleById($review['FK_article_id']);
            $this->header = array(
                'title' => 'Recenze '. $article['title'],
                'description' => 'notes',
                'keywords' => 'recenze, ' . $article['keywords']
            );

            $this->data = array(
                'FK_article_id' => $review['FK_article_id'],
                'lingvistic' => $review['lingvistic'],
                'notes' => $review['notes'],
                'score' => $review['score'],
                'technical' => $review['technical'],
                'reviewer_id' => $review['reviewer_id'],
                'article' => $article
            );
            $this->view = 'review';
        }
    }
}