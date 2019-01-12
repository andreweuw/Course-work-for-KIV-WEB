<?php

class ContactController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Kontaktní formulář',
            'description' => 'Kontaktní formulář našeho webu.',
            'keywords' => 'kontakt, email, formulář'
        );

        if ($_POST) {
            try {
                $emailSender = new EmailSender();
                $emailSender->sendWithAntiSpam($_POST['year'], "ondrejhavlicek98@gmail.com", "Ohlas z webu", $_POST['message'], $_POST['email']);
                $this->addMessage('Email byl úspěšně odeslán.');
                $this->redirect('contact');
            }
            catch (UserError $error) {
                $this->addMessage($error->getMessage());
            }
        }
        
        $this->view = 'contact';
    }
}