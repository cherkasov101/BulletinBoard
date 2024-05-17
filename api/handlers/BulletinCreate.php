<?php

declare(strict_types=1);

namespace api\handlers;

class BulletinCreateHandler {
    private $db;

    public function __construct() {
        $this->db = new \SQLite3("db/bb.db");
        $this->db->exec('CREATE TABLE IF NOT EXISTS bulletins (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT, content TEXT)');
    }

    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo 'Method Not Allowed';
            return;
        }

        session_start();

        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            http_response_code(401);
            echo 'Unauthorized';
            return;
        }

        $requestData = json_decode(file_get_contents('php://input'), true);

        if (!isset($requestData['title']) || !isset($requestData['content'])) {
            http_response_code(400);
            echo 'Bad Request';
            return;
        }

        $title = $requestData['title'];
        $content = $requestData['content'];

        $stmt = $this->db->prepare("INSERT INTO bulletins (title, content) VALUES (:title, :content)");
        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':content', $content, SQLITE3_TEXT);
        $result = $stmt->execute();

        if ($result) {
            http_response_code(201);
            echo json_encode(array('message' => 'Bulletin created successfully'));
        } else {
            http_response_code(500);
            echo 'Internal Server Error';
        }
    }
}