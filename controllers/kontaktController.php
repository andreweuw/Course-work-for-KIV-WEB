<?php

class kontaktController extends baseController
{
    //kazdy controller ma indexAction!!!!
    public function indexAction($params)
    {
        $html = phpWrapperFromFile("controllers/kontakt.php", $params);
        //echo $html;
        $pages = $params["pages"];


        //extract($params); muze prespat moje $html

        $this->render($html, $pages);
    }
}