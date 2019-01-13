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
            'password' => $this->getHash($pass),
            'status' => 'autor'
        );
        try {
            DBWrapper::add('users', $user);
        }
        catch (PDOException $error) {
            echo $error;
            throw new UserError('Uživatel s tímto jménem již v systému existuje.');
        }
    }

    public function raiseRank($id) {
        $user = DBWrapper::getRow('
            SELECT user_id, username, password, status
            FROM users 
            WHERE user_id = ?
            ', $id
        );
        if ($user['status'] == 'autor') {
            $nextRank = 'recenzent';
        } else if ($user['status'] == 'recenzent') {
            $nextRank = 'administrator';
        } else if ($user['status'] == 'administrator') {
            throw new UserError('Uživatel je již administrátorem.');
        }
        DBWrapper::update('users');
    }

    public function login($name, $pass) {
        $user = DBWrapper::getRow('
                SELECT user_id, username, password, status
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

    public function getAllUsers() {
        return DBWrapper::getAllRows('
            SELECT `user_id`, `username`, `password`, `status`
            FROM `users`
            ORDER BY `user_id` DESC
        ');
    }
}