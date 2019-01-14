<?php

class EditorController extends Controller {
    

public function process($params) {
        $this->header = array(
            'title' => 'Editor článků',
            'keywords' => 'Tato stránka je určena k editaci a vytváření článků.',
            'description' => 'editace, edit, article, článek, admin');

        $articleManager = new ArticleManager();
        // Expecting to edit a new article
        // Je odeslán formulář
        $article = array(
            'title' => '',
            'pdf' => '',
            'url' => '',
            'abstract' => '',
            'description' => '',
            'keywords' => ''
        );
        if ($_POST) {
            // Uložení článku do DB
            $articleManager->saveArticle($_POST['title'], $_POST['pdf'], $_POST['url'], $_POST['abstract'], $_POST['description'], $_POST['keywords']);
            $article = array(
                'title' => $_POST['title'],
                'pdf' => $_POST['pdf'],
                'url' => $_POST['url'],
                'abstract' => $_POST['abstract'],
                'description' => $_POST['description'],
                'keywords' => $_POST['keywords']
            );

            $path = 'localhost/articles/'.$article['pdf'];
            file_put_contents($path, $article['pdf']);
            $articleController->addMessage($path . '   pdf:'.$article['pdf']);
            $this->redirect('article');
        }
        // Je zadané URL článku k editaci
        else if (!empty($params[1])) {
            $bufferedArticle = $articleManager->getArticle($params[1]);

            if ($bufferedArticle) {
                $article = $bufferedArticle;
            }      
            else {
                $this->addMessage('params[1]: ' . $params[1]);
             }                     
        }

        $this->data['article'] = $article;

        $this->view = 'editor';
    }
    
}