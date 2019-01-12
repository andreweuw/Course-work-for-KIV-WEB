<?php

class AdministrationController extends Controller
{
    public function process($params)
    {
        // Do administrace mají přístup jen přihlášení uživatelé
        $this->verifyUser();
        // Hlavička stránky
        $this->header['title'] = 'Přihlášení';
        // Získání dat o přihlášeném uživateli
        $userManager = new UserManager();
        if (!empty($params[0]) && $params[0] == 'logout') {
            $userManager->logout();
            $this->redirect('login');
        }
        $user = $userManager->getUser();
        $this->data['name'] = $user['name'];
        $this->data['admin'] = $user['admin'];
        // Nastavení šablony
        $this->pohled = 'administration';
    }
}