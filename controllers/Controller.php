<?php
abstract class Controller {

    protected $data = array();
    protected $view = "";
    protected $header = array('title' => '', 'description' => '', 'keywords' => '');

    abstract function process($params);

    public function printView() {
        if ($this->view) {
            extract($this->entitize($this->data));
            // Extract the data once again in case of formated HTML text WITH their prefixes (expects '_' prefix of the data piece)
            extract($this->data, EXTR_PREFIX_ALL, "");
            require("views/" . $this->view . ".phtml");
        }
    }

    public function redirect($url) {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }

    /**
     * Entitize all the incoming data in the case of cross-site scripting
     */
    private function entitize($var = null) {
        if (!isset($var)) {
            return null;
        }
        elseif (is_string($var)) {
            // Calling ENT_QUOTES for the case of single quote strings
            return htmlspecialchars($var, ENT_QUOTES);
        }
        elseif (is_array($var)) {
            foreach ($var as $index => $item) {
                $var[$index] = $this->entitize($item);
            }
            return $var;
        }
        else {
            return $var;
        }
    }

}