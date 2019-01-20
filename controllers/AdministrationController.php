<?php

/**
 * Uživatelský administrace
 */
class AdministrationController extends Controller
{
    public function process($params)
    {
        // Do administrace mají přístup jen přihlášení uživatelé
        $userManager = new UserManager();
        $user = $userManager->getUser();
		// Zablokovaný účet
        if ($user['blocked']) {
            $this->addMessage('Tento účet je zablokovaný administrátorem. Pokuď si myslíte, že jde o omyl, obraťte se na kontakt v patičce stránky.');
            $userManager->logout();
            $this->redirect('home');
        }

        $this->header = array(
            'title' => 'Administrace',
            'description' => 'Na této stránce může uživatel využívat svoje pravomoce.',
            'keywords' => 'uzivatel, user, admin, editation');
        if (!empty($params[0])) {
            switch ($params[0]) {
                case 'logout':
                    $userManager->logout();
                    $this->redirect('home');
                    break;
                case 'delete':
                    $userManager->deleteUser($params[1]);
                    $this->redirect('users');
                break;
                case 'raiseRank':
                    $userManager->raiseRank($params[1]);
                    $this->redirect('users');
                    break;
                case 'lowerRank':
                    $userManager->lowerRank($params[1]);
                    $this->redirect('users');
                    break;
                case 'block':		// Zablokování
                    $userManager->block($params[1], true);
                    $this->redirect('users');
                    break;
                case 'unblock': // ODblokování uživatele
                    $userManager->block($params[1], false);
                    $this->redirect('users');
                    break;
                default:
                    break;
            }
        }

        $user = $userManager->getUser();
        $this->data['username'] = $user['username'];
        $this->data['status'] = $user['status'];
        $this->data['blocked'] = $user['blocked'];
        
		// V administraci každý uživatel vidí jen to, co může. Proto není třeba verifikovat různé úrovně uživatelů v průběhu.
        $this->view = 'administration';
    }
}