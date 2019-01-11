<?php

class DBWrapper {

    private static $connection;

    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );

    /**
     * Creates an instace of PDO with standard connection parameters
     * and stores it in a static variable $connection.
     * It also prevents further connection.
     */
    public static function connect($host, $user, $password, $database) {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $password,
                self::$settings
            );
        }
    }

    /**
     * Returns one single row of the database
     */
    public static function getRow($query, $params = array()) {
        $return = self::$connection->prepare($query);
        $return->execute($params);
        return $return->fetch();
    }

    /**
     * Returns all the rows of the database
     */
    public static function getAllRows($query, $params = array()) {
        $return = self::$connection->prepare($query);
        $return->execute($params);
        return $return->fetchAll();
    }

    /**
     * Returns one single column of the database
     */
    public static function getColumn($query, $params = array()) {
        $result = self::getRow($query, $params);
        return $result[0];
    }

    /**
     * Returns te number of edited rows
     */
    public static function getEditedCount($query, $params = array()) {
        $return = self::$connection->prepare($query);
        $return->execute($params);
        return $return->rowCount();
    }
}