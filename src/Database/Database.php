<?php

namespace App\Database;

use PDO;

class Database {
    private static $conn;

    public static function getConnection() {
        if (!self::$conn) {
            self::$conn = new PDO('sqlite:' . __DIR__ . '/../../database/chat.db');
            self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$conn;
    }
}