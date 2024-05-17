<?php

declare(strict_types=1);

namespace api\handlers;

class RegistrationHandler { 
    private $db;

    public function __construct() {
        $this->db = new \SQLite3("db/bb.db");
        $this->db->exec('CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY AUTOINCREMENT, username TEXT, password TEXT)');
    }

    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method Not Allowed';
            return;
        }

        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!isset($requestData['username']) || !isset($requestData['password'])) {
            http_response_code(400);
            echo 'Bad Request';
            return;
        }

        $username = $requestData['username'];
        $password = $requestData['password'];

        $this->db->exec("INSERT INTO users (username, password) VALUES ('$username', '$password')");

        http_response_code(200);
        echo json_encode(array('message' => 'User registered successfully'));
    }
}