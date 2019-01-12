<?php

class LoginController extends Controller {

    public function process($params) {
        $userManager = new UserManager();
        if ($userManager->getUser()) {
            $this->redirect('administrace');
        } 
        // Hlavička stránky
        $this->header['title'] = 'Přihlášení';
        if ($_POST)
        {
            try
            {
                $userManager->login($_POST['name'], $_POST['pass']);
                $this->addMessage('Byl jste úspěšně přihlášen.');
                $this->redirect('administration');
            }
            catch (UserError $error)
            {
                $this->addMessage($error->getMessage());
     }
        }
        // Nastavení šablony
        $this->view = 'prihlaseni';
    }
}