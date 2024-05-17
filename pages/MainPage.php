<?php

declare(strict_types=1);

namespace pages;

class MainPage
{
    public function handle(): void
    {
        session_start();

        if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
            header('Content-Type: text/html; charset=utf-8');
            include __DIR__ . '/../frontend/html/login_page.html';
            return;
        }

        header('Content-Type: text/html; charset=utf-8');
        include __DIR__ . '/../frontend/html/main_page.html';
    }
}