<?php

class ReviewEditorController extends Controller {
    

public function process($params) {
        $this->header = array(
            'title' => 'Editor recenzí',
            'keywords' => 'Tato stránka je určena k editaci a vytváření recenzí.',
            'description' => 'editace, edit, review, recenze, recenzent');

        $reviewManager = new ReviewManager();
        
        if (!empty($params[0])) {
            $review = $reviewManager->getReviewById($params[0]);
            $this->data['review'] = $review;
            $this->data['FK_article_id'] = $params[0];
        }

        if ($_POST) {
            $reviewManager->saveReview(
                ($this->data['review'])['FK_article_id'],
                $this->data['FK_article_id'],
                $_POST['lingvistic'],
                $_POST['notes'],
                $_POST['score'],
                $_POST['technical']
            );
            $review = array(
                'FK_article_id' => $_POST['FK_article_id'],
                'lingvistic' => $_POST['lingvistic'],
                'notes' => $_POST['notes'],
                'score' => $_POST['score'],
                'technical' => $_POST['technical'],
            );
 
            $this->redirect('review');
        }
        // Je zadané URL článku k editaci
        $this->data['review'] = $review;
        $this->view = 'reviewEditor';
    }
    
}