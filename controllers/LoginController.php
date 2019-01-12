<?php

class LoginController extends Controller {

    public function process($params) {
        $userManager = new UserManager();
        if ($userManager->getUser()) {
            $this->redirect('administration');
        } 
        // Hlavička stránky
        $this->header = array(
            'title' => 'Přihlášení',
            'description' => 'Tato stránka je určena k přihlášení uživatele.',
            'keywords' => 'přihlášení, login, uživatel');
        if ($_POST)
        {
            try
            {
                $userManager->login($_POST['username'], $_POST['password']);
                $this->addMessage('Byl jste úspěšně přihlášen.');
                $this->redirect('administration');
            }
            catch (UserError $error)
            {
                $this->addMessage($error->getMessage());
            }
        }
        // Nastavení šablony
        $this->view = 'login';
    }
}