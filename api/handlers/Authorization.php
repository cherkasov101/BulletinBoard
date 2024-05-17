<?php

declare(strict_types=1);

namespace api\handlers;

class AuthorizationHandler {
    private $db;

    public function __construct() {
        $this->db = new \SQLite3("db/bb.db");
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

        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindValue(':username', $username, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            if ($password === $row['password']) {
                session_start();
                $_SESSION['authenticated'] = true;
                http_response_code(200);
                echo json_encode(array('message' => 'User authenticated successfully'));
            } else {
                http_response_code(401);
                echo 'Unauthorized';
            }
        } else {
            http_response_code(401);
            echo 'Unauthorized';
        }
    }
}