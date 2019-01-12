<?php

class EditorController extends Controller {

    public function process($params) {
        $this->verifyUser(true);
        $this->header = array(
            'title' => 'Editor článků',
            'description' => 'Tato stránka je určena k editaci a vytváření článků.',
            'keywords' => 'editace, edit, article, článek, admin');

        $articleManager = new ArticleManager();
        // Expecting to edit a new article
        $article = array(
            'article_id' => '',
            'title' => '',
            'content' => '',
            'url' => '',
            'description' => '',
            'keywords' => '',
        );
        // Je odeslán formulář
        if ($_POST) {
            // Získání článku z $_POST
            $keys = array('title', 'content', 'url', 'description', 'keywords');
            $article = array_intersect_key($_POST, array_flip($keys));
            // Uložení článku do DB
            $articleManager->saveArticle($_POST['clanky_id'], $article);
                $this->addMessage('Článek byl úspěšně uložen.');
                $this->redirect('article/' . $article['url']);
        }
        // Je zadané URL článku k editaci
        else if (!empty($params[0])) {
            $bufferedArticle = $articleManager->getArticle($params[0]);
            if ($bufferedArticle) {
                $article = $bufferedArticle;
            }      
            else {
                $this->addMessage('Článek nebyl nalezen');
             }                     
        }

        $this->data['article'] = $article;
        $this->view = 'editor';
    }
}