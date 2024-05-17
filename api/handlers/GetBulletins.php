<?php

declare(strict_types=1);

namespace api\handlers;

class GetBulletinsHandler {
    private $db;

    public function __construct() {
        $this->db = new \SQLite3("db/bb.db");
    }

    public function handle() {
        if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
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

        $stmt = $this->db->query("SELECT * FROM bulletins");
        
        $bulletins = array();

        while ($row = $stmt->fetchArray(SQLITE3_ASSOC)) {
            $bulletins[] = $row;
        }

        header('Content-Type: application/json');
        echo json_encode($bulletins);
    }
}