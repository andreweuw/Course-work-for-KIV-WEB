<?php

class RouterController extends Controller {

    protected $controller;

    public function process($params) {
        $parsedURL = $this->parseURL($params[0]);

        if (empty($parsedURL[0])) {
            $this->redirect('clanek/uvod');
        }
        
        $controllerClass = $this->dashToCamel(array_shift($parsedURL)) . 'Controller';
        
        if (file_exists('controllers/' . $controllerClass . '.php')) {
            $this->controller = new $controllerClass;
        }
        else {
            $this->redirect('error');
        }

        $this->controller->process($parsedURL);

        $this->data['title'] = $this->controller->header['title'];
        $this->data['description'] = $this->controller->header['description'];
        $this->data['keywords'] = $this->controller->header['keywords'];
        $this->view = 'layout';

    }

    private function parseURL($url) {
        $parsedURL = parse_url($url);
        $parsedURL["path"] = ltrim($parsedURL["path"], "/");
        $parsedURL["path"] = trim($parsedURL["path"]);
        $disconnectedPath = explode("/", $parsedURL["path"]);
        return $disconnectedPath;
    }

    private function dashToCamel($text) {
        $str = str_replace('-', ' ', $text);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        return $str;
    }
}