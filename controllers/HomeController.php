<?php

class HomeController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Domovská stránka',
            'keywords' => 'jazyk, homepage, home, konference',
            'description' => 'Domovská stránka webu.'
        );

        $articleManager = new ArticleManager();
        $this->data['articles'] = $articleManager->getAllPublished();
        $this->view = 'home';
    }
}