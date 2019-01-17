<?php

class ArticleController extends Controller {

    public function process($params) {
        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $reviewManager = new ReviewManager();
        $user = $userManager->getUser();
        $this->data['status'] = $user && $user['status'];

        if (!empty($params[1]) && $params[1] == 'remove') {
            $article = $articleManager->getArticle($params[0]);
            $articleManager->deleteArticle($article['article_id']);
            $articleManager->deletePdf($article['file_name']);
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

            $this->data = array(
                'article_id' => $article['article_id'],
                'title' => $article['title'],
                'abstract' => $article['abstract'],
                'description' => $article['description'],
                'url' => $article['url'],
                'author' => $article['FK_user_id'],
                'keywords' => $article['keywords'],
                'score' => $reviewManager->getScoreForArticle($article['article_id']),
                'file_name' => $article['file_name']
            );
            $this->view = 'article';
        }
        else {
            $articles = $articleManager->getArticles();
            $this->data['articles'] = $articles;
            $this->view = 'articles';
        }
    }
}