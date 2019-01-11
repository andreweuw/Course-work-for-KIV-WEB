<?php

class notFoundController extends baseController
{
    //kazdy controller ma indexAction!!!!
    public function indexAction($params)
    {
        $html = phpWrapperFromFile("controllers/notFound.php", $params);
        //echo $html;
        $pages = $params["pages"];


        //extract($params); muze prespat moje $html

        $this->render($html, $pages);
    }
}