<?php

class baseController {

    //Protected, aby bylo viditelne do homeControlleru, jinak
    protected $twig;
    /**
     * @var userModel
     */
    protected $user;

    public function __construct($twig, $containerOfModels)
    {
        $this->twig = $twig;
        if ($containerOfModels != null) {
            foreach ($containerOfModels as $nazev_modelu => $model) {
                $this->$nazev_modelu = $model;
            }
        }
    }

    public function indexAction($params) {
        return "Missing indexAction method";
    }

    /**
     * TODO metoda pro generovani URL na webu
     */
    public function makeUrl() {

    }

    public function render($obsah, $pages)
    {
        //vypsat sablonu pres twig
        echo $this->twig->render("sablona1.htm", array("obsah" => $obsah, "pages" => $pages));
    }
}