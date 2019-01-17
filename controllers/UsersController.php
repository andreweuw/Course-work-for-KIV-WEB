<?php

/**
* Just for showing all the users
*/
class UsersController extends Controller {

    public function process($params) {
        $this->header = array(
            'title' => 'Editace uživatelských práv',
            'description' => 'Tato stránka je určena k editaci uživatelských práv jiných uživatelů.',
            'keywords' => 'editace, edit, uzivatele, users, admin, prava, status');

        $userManager = new UserManager();
        $users = $userManager->getAllUsers();
        $this->data['users'] = $users;
        $this->view = 'users';
    }
}