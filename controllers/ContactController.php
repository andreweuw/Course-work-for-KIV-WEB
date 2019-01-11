<?php

class ContactController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Kontaktní formulář',
            'description' => 'Kontaktní formulář našeho webu.',
            'keywords' => 'kontakt, email, formulář'
        );

        if (isset($_POST["email"])) {
            if ($_POST['year'] == date("Y")) {
                $emailSender = new EmailSender();
                $emailSender->send("ondrejhavlicek98@gmail.com", "Ohlas z webu", $_POST['message'], $_POST['email']);
            }
        }

        $this->view = 'contact';
    }
}