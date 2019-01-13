<?php

class AdministrationController extends Controller
{
    public function process($params)
    {
        // Do administrace mají přístup jen přihlášení uživatelé
        $this->verifyUser();
        // Hlavička stránky
        $this->header = array(
            'title' => 'Administrace',
            'description' => 'Na této stránce může uživatel využívat pravomoce.',
            'keywords' => 'uzivatel, user, admin, editation');
        // Získání dat o přihlášeném uživateli
        $userManager = new UserManager();
        if (!empty($params[0]) && $params[0] == 'logout') {
            $userManager->logout();
            $this->redirect('home');
        }
        $user = $userManager->getUser();
        $this->data['username'] = $user['username'];
        $this->data['status'] = $user['status'];
        // Nastavení šablony
        $this->view = 'administration';
    }
}