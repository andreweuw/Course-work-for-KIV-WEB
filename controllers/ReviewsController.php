<?php

/**
 * Stránka pro administrátora, je na ní možné editoat práva uživatelů, nebo publikovat/ odmítat příspěvky
 */
class ReviewsController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Editace uživatelských práv',
            'description' => 'Tato stránka je určena k editaci uživatelských práv jiných uživatlů a publikování nebo odmítání příspěvků.',
            'keywords' => 'editace, edit, uzivatele, users, admin, prava, status');

        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $reviewManager = new ReviewManager();

        $articles = $articleManager->getArticles();
        $this->data['reviewers'] = $userManager->getAllReviewers();
        $this->data['max_count'] = ($articleManager->getMaxRev())[0];
        $this->data['articles'] = $articles;
        $this->view = 'reviews';
        $this->data['reviews'] = $reviewManager->getReviews();

        if (isset($_POST['reviewers'])) {
            $articleManager->updateReviewers($_POST['reviewers'], $_POST['count'], $_POST['article_id']);
            $this->redirect('reviews');
        }

        if (!empty($params[0]) && $params[0] == 'add') {
            $articleManager->updateRevCount($params[2], true);
            $this->redirect('reviews');
        }
        else if(!empty($params[0]) && $params[0] == 'remove') {
            $articleManager->updateRevCount($params[2], false);
            $this->redirect('reviews');
        }
        else if(!empty($params[0]) && $params[0] == 'publish') {
            $articleManager->setPublished($params[1]);
            $articleManager->raiseState($params[1]);
            $this->redirect('home');
        }
        else if(!empty($params[0]) && $params[0] == 'decline') {
            $articleManager->lowerState($params[1]);
        }
    }
}