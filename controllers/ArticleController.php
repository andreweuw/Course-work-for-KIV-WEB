<?php

class ArticleController extends Controller {

    public function process($params) {
        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();
        $this->data['status'] = $user && $user['status'];

        if (!empty($params[1]) && $params[1] == 'remove') {
            $article = $articleManager->getArticle($params[0]);
            $articleManager->deleteArticle($article['article_id']);
            $this->redirect('article');
        }
        elseif (!empty($params[0])) {
            $article = $articleManager->getArticle($params[0]);
            if (!$article) {
                $this->addMessage('params[0]: ' . $params[0]);
            }

            $this->header = array(
                'title' => $article['title'],
                'description' => $article['description'],
                'keywords' => $article['keywords'],
            );

            $this->data['title'] = $article['title'];
            $this->data['abstract'] = $article['abstract'];
            $this->data['pdf'] = $article['pdf'];
            $this->view = 'article';
        }
        else {
            $articles = $articleManager->getArticles();
            $this->data['articles'] = $articles;
            $this->view = 'articles';
        }
    }
}