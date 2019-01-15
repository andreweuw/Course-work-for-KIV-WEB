<?php

class EditorController extends Controller {
    

public function process($params) {
        $this->header = array(
            'title' => 'Editor článků',
            'keywords' => 'Tato stránka je určena k editaci a vytváření článků.',
            'description' => 'editace, edit, article, článek, admin');

        $articleManager = new ArticleManager();
        
        if (!empty($params[0]) && $params[0] == 'display') {
            $articleManager->downloadPdf('articles/' . (substr($params[1], 0, strlen($params[1])- 4)));
        }
        else if (!empty($params[0])) {
            $article = $articleManager->getArticleById($params[0]);
            $this->data['article'] = $article;
            $this->view = ('editor');
        }
        else {
            $article = array(
                'title' => '',
                'pdf' => '',
                'url' => '',
                'abstract' => '',
                'description' => '',
                'keywords' => ''
            );
        }

        if ($_POST) {
            $articleManager->saveArticle(
                $_POST['title'],
                $_POST['url'],
                $_POST['abstract'],
                $_POST['description'],
                $_POST['keywords'],
                $_POST['url'] . '_' . $_FILES['file']['name']
            );
            $articleManager->uploadPDF($_POST['url'] . '_' . $_FILES['file']['name'], $_FILES['file']['tmp_name']);
            $article = array(
                'title' => $_POST['title'],
                'pdf' => $_POST['pdf'],
                'url' => $_POST['url'],
                'abstract' => $_POST['abstract'],
                'description' => $_POST['description'],
                'keywords' => $_POST['keywords'],
                'file_name' => $_POST['url'] . '_' . $_FILES['file']['name']
            );
 
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