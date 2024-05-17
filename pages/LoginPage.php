<?php

declare(strict_types=1);

namespace pages;

class LoginPage
{
    public function handle(): void
    {
        header('Content-Type: text/html; charset=utf-8');
        include __DIR__ . '/../frontend/html/login_page.html';
    }
}