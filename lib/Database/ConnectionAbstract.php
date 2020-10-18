<?php

namespace Database;

abstract class ConnectionAbstract {

    private static $conn;

    public static function getConn() {
        if (self::$conn == null) {

            self::$conn = new \PDO('mysql: host=localhost; dbname=projetofinal2', 'userweb', 'S3nh@L0c@1');
        }
        return self::$conn;
    }

}