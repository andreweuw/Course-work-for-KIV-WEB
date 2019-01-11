<?php

class uvodController extends baseController
{
    //kazdy controller ma indexAction!!!!
    public function indexAction($params)
    {
        //nacist vsechny uzivatele, nebo jednoho...
        $knihy = $this->user->LoadAllUsers();

        $pages = $params["pages"];
        $params["knihy"] = $knihy;

        $html = phpWrapperFromFile("controllers/uvod.php", $params);

        //echo $html;

        //extract($params); muze prespat moje $html

        $this->render($html, $pages);
    }
}