<?php

class routerController extends AController {

    protected $controller;

    public function processParams($params) {
        $parsedURL = $this->parseURL($params[0]);
        if (empty($parsedURL[0])) {
             $this->redirect('clanek/uvod');
        }

        if (file_exists('controllers/' . $controllerClass . '.php')) {
            $this->controller = new $controllerClass;
        }
        else {
            $this->redirect('error');
        }

        $this->controller->proccessParams($parsedURL);
        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keyWords'] = $this->controller->header['keyWords'];
        $this->view = 'layout';

        $controllerClass = $this->dashToCamelC(array_shift($parsedURL)) . 'Controller';
    }

    private function parseURL($url) {
        $parsedURL = parse_url($url);
        $parsedURL["path"] = ltrim($parsedURL["path"], "/");
        $parsedURL["path"] = trim($parsedURL["path"], "/");

        $dividedPath = explode("/", $parsedURL["path"]);
        return $dividedPath;
    }

    private function dashToCamelC($text)
    {
        $str = str_replace('-', ' ', $text);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }
}