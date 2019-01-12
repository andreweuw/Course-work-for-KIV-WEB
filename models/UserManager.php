<?php

class UserManager {

    public function getHash($pass) {
        // Also adds salt (additional random string)
        // so that the password is not weak.
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function register($name, $pass, $passAgain, $year) {
        if ($year != date('Y')) {
            throw new UserError('Špatně vyplněný antispam.');
        }
        if ($pass != $passAgain) {
            throw new UserError('Zadaná hesla spolu nesouhlasí.');
        }
        $user = array(
            'username' => $name,
            'password' => $this->getHash($pass)
        );
        try {
            DBWrapper::add('users', $user);
        }
        catch (PDOException $error) {
            echo $error;
            throw new UserError('Uživatel s tímto jménem již v systému existuje.');
        }
    }

    public function login($name, $pass) {
        $user = DBWrapper::getRow('
                SELECT user_id, username, password, admin
                FROM users 
                WHERE username = ?
                ', array($name)
        );
        if (!$user || !password_verify($pass, $user['password'])) {
            throw new UserError('Chybně zadané jméno, nebo heslo.');
        }
        $_SESSION['user'] = $user;
    }

    public function logout() {
        unset($_SESSION['user']);
    }

    public function getUser() {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return null;
    }
}