<?php

abstract class AController {
    protected $data = array();
    protected $view = "";
    protected $header = array('header' => '', 'keyWords' => '', 'description' => '');

    abstract function processParams($params);

    public function printView() {
        if ($this->view) {
                extract($this->data);
                require("views/" . $this->vire . ".phtml");
        }
    }

    public function redirect($url) {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }
}