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
            'name' => $name,
            'pass' => $this->getHash($pass)
        );
        try {
            DBWrapper::add('uzivatele', $user);
        }
        catch (PDOException $error) {
            throw new UserError('Uživatel s tímto jménem již v systému existuje.');
        }
    }

    public function login($name, $pass) {
        $user = DBWrapper::getRow('
                SELECT uzivatele_id, jmeno, admin, heslo
                FROM uzivatele 
                WHERE jmeno = ?
                ', array($name)
        );
        if (!$user || !password_verify($pass, $user['pass'])) {
            throw new UserException('Chybně zadané jméno, nebo heslo.');
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