<?php

/**
 * Články jednotlivého autora
 */
class MyArticlesController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Moje příspěvky',
            'description' => 'Tato stránka je určena k prohlédnutí příspěvků uživatele v roli autora.',
            'keywords' => 'prohlednuti, autor, review, prispevek, prispevky');

        $articleManager = new ArticleManager();
        $userManager = new UserManager();
        $user = $userManager->getUser();

        if (!empty($params[1]) && $params[1] == 'alter') {
            $article = $articleManager->getArticle($params[0]);
            $articleManager->deleteArticle($article['article_id']);
            $articleManager->deletePdf($article['file_name']);
            $this->redirect('editor');
        }

        $articles = $articleManager->getMyArticles($user['user_id']);
        $this->data['articles'] = $articles;
        $this->view = 'myArticles';
    }
}