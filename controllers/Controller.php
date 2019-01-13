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

    public function addMessage($message) {
        if (isset($_SESSION['messages'])) {
            $_SESSION['messages'][] = $message;
        }
        else {
            $_SESSION['messages'] = array($message);
        }
    }

    public static function getMessages() {
        if (isset($_SESSION['messages'])) {
            $messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $messages;
        }
        else {
            return array();
        }
    }

    public function verifyUser($admin = false) {
        $userManager = new UserManager();
        $user = $userManager->getUser();
        if (!$user || ($admin && ($user['status'] != 'administrator'))) {
            $this->addMessage('Je nám líto, ale k této akci nemáte dostatečná oprávnění.');
            $this->redirect('login');
        }
    }

}