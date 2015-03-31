<?php

namespace connection;

class Connection {
    private static $connection_data = [];

    public static function connect () {
        $con = mysqli_connect(self::$connection_data['host'],
                              self::$connection_data['user'],
                              self::$connection_data['pass'],
                              self::$connection_data['database']);
        if (!$con) {
            die('Could not connect to database!');
        }

        return $con;
    }

    public static function setConnectionData($data) {
        self::$connection_data = $data;
    }
}
