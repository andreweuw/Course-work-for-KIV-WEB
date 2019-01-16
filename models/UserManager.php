<?php

class UserManager {

    public function getHash($pass) {
        // Also adds salt (additional random string)
        // so that the password is not weak.
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    public function register($name, $pass, $passAgain) {
        if ($pass != $passAgain) {
            throw new UserError('Zadaná hesla spolu nesouhlasí.');
        }
        $user = array(
            'username' => $name,
            'password' => $this->getHash($pass),
            'status' => 'autor',
            'blocked' => false
        );
        try {
            DBWrapper::add('users', $user);
        }
        catch (PDOException $error) {
            throw new UserError('Uživatel s tímto jménem již v systému existuje.');
        }
    }

    public function block($id, $val) {
        $controller = new UsersController();
        if (DBWrapper::query("UPDATE users SET `blocked` = ? WHERE user_id = ?", array($val, $id)) > 0) {
            $controller->addMessage('Uživatel s id '. $id . ' byl úspěšně blokován');
        }
        else {
            $controller->addMessage('Provádíte zbytečnou operaci, blokování / odblokování nebylo provedeno.');
        }
        
    }

    public function raiseRank($id) {
        $controller = new UsersController();
        $user = DBWrapper::getRow('
            SELECT user_id, username, password, status, blocked
            FROM users 
            WHERE user_id = ?
            ', array($id)
        );
        $status = $user['status'];
        if ($status == 'autor') {
            $nextRank = 'recenzent';
        } else if ($status == 'recenzent') {
            $nextRank = 'administrator';
        } else if ($status == 'administrator') {
            $nextRank = null;
        }
        // public static function alter($table, $values = array(), $condition, $params = array()) {  
        if ($nextRank) {
            DBWrapper::query("UPDATE users SET `status` = ? WHERE user_id = ?", array($nextRank, $id));
            $controller->addMessage('Uživatel s id '. $id . ' byl úspěšně povýšen');
        }
        else {
            $controller->addMessage('Uživatel je již administrátorem.');
        }
    }

    public function lowerRank($id) {
        $controller = new UsersController();
        $user = DBWrapper::getRow('
            SELECT user_id, username, password, status, blocked
            FROM users 
            WHERE user_id = ?
            ', array($id)
        );
        $status = $user['status'];
        if ($status == 'administrator') {
            $nextRank = 'recenzent';
        } else if ($status == 'recenzent') {
            $nextRank = 'autor';
        } else if ($status == 'autor') {
            $nextRank = null;
        }
        // public static function alter($table, $values = array(), $condition, $params = array()) {  
        if ($nextRank) {
            DBWrapper::query("UPDATE users SET `status` = ? WHERE user_id = ?", array($nextRank, $id));
            $controller->addMessage('Uživatel s id '. $id . ' byl úspěšně zbaven dřívější funkce');
        }
        else {
            $controller->addMessage('Uživatel je již autorem.');
        }
    }

    public function login($name, $pass) {
        $user = DBWrapper::getRow('
                SELECT user_id, username, password, status, blocked 
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

    public function getUserById($id) {
        return DBWrapper::getRow('
            SELECT * 
            FROM `users` 
            WHERE `user_id` = ?
            ', array($id)
        );
    }

    public function getAllUsers() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `users`
            ORDER BY `user_id` DESC
        ');
    }

    public function getAllReviewers() {
        return DBWrapper::getAllRows('
            SELECT * 
            FROM `users` 
            WHERE `status` = ? 
            ORDER BY `user_id` DESC
        ', array('recenzent'));
    }

    public function deleteUser($id) {
        $controller = new UsersController();
        DBWrapper::query('
            DELETE FROM users WHERE user_id = ? 
        ', array($id));
        $controller->addMessage('Uživatel s id '. $id . ' byl úspěšně odstraněn');
    }
}