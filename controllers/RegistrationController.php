<?php

class RegistrationController extends Controller {

    public function process($params) {
        $this->header['title'] = 'Registrace';
        if ($_POST) {
            try {
                $userManager = new UserManager();
                $userManager->register($_POST['name'], $_POST['pass'], $_POST['passAgain'], $_POST['year']);
                $userManager->login($_POST['name'], $_POST['pass']);
                $this->addMessage('Registrace proběhla úspěšně!');
                $this->redirect('administration');
            }
            catch (UserError $error) {
                $this->addMessage($error->getMessage());
            }
        }

        $this->view = 'registration';
    }
}