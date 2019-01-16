<?php

class ReviewsController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Editace uživatelských práv',
            'description' => 'Tato stránka je určena k editaci uživatelských práv jiných uživatlů.',
            'keywords' => 'editace, edit, uzivatele, users, admin, prava, status');

        $articleManager = new ArticleManager();
        $userManager = new UserManager();

        $articles = $articleManager->getArticles();
        $this->data['reviewers'] = $userManager->getAllReviewers();
        $this->data['max_count'] = ($articleManager->getMaxRev())[0];
        $this->data['articles'] = $articles;
        $this->view = 'reviews';

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
    }
}