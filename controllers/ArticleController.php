<?php

class ArticleController extends Controller {

    public function process($params) {
        $articleManager = new ArticleManager();

        if (!empty($params[0])) {
            $article = $articleManager->getArticle($params[0]);

            if (!$article) {
                $this->redirect('error');
            }

            $this->header = array(
                'title' => $article['titulek'],
                'description' => $article['popisek'],
                'keywords' => $article['klicova_slova']
            );

            $this->data['title'] = $article['titulek'];
            $this->data['content'] = $article['obsah'];

            $this->view = 'article';
        }
        else {
            $articles = $articleManager->getArticles();
            $this->data['articles'] = $articles;
            $this->view = 'articles';
        }
    }
}