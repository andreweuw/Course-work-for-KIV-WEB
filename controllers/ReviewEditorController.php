<?php

/**
 * Stránka editoru recenzí
 */
class ReviewEditorController extends Controller {
    

    public function process($params) {
        $this->header = array(
            'title' => 'Editor recenzí',
            'keywords' => 'Tato stránka je určena k editaci a vytváření recenzí.',
            'description' => 'editace, edit, review, recenze, recenzent');

        $reviewManager = new ReviewManager();
        $articleManager = new ArticleManager();
        $user = (new UserManager())->getUser();

        if (!empty($params[0]) && $params[0] == 'prepare') {
            $review = $reviewManager->getReviewByArticle($params[1]);
            $article = $articleManager->getArticleById($params[1]);
            $this->data['review'] = $review;
            $this->data['article'] = $article;
        }
        else if (!empty($params[0]) && $params[0] == 'edit') {
            $review = $reviewManager->getReviewByArticle($params[1]);
            $article = $articleManager->getArticleById($params[1]);
            $this->data['review'] = $review;
            $this->data['article'] = $article;
        }
        else if (!empty($params[0]) && $params[0] == 'remove') {
            $review = $reviewManager->getReviewByArticle($params[1]);
            $article = $articleManager->getArticleById($params[1]);
            $reviewManager->deleteReview($review['review_id']);
            $articleManager->lowerState($article['article_id']);
            $this->redirect('myReviews');
        }

        if ($_POST) {
            if (!$reviewManager->isFirstReview($this->data['article']['article_id'])) {
                $articleManager->raiseState($this->data['article']['article_id']);
            }

            $review = array(
                'FK_article_id' => $this->data['article']['article_id'],
                'lingvistic' => $_POST['lingvistic'],
                'notes' => $_POST['notes'],
                'score' => $_POST['score'],
                'technical' => $_POST['technical'],
                'reviewer_id' => $user['user_id']
            );
            
            $reviewManager->saveReview($review);

            $this->redirect('myReviews');
        }

        $this->data['review'] = $review;
        $this->view = 'reviewEditor';
    }
    
}