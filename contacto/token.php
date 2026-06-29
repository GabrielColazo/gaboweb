<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (empty($_SESSION['form_token'])) {
    $_SESSION['form_token'] = bin2hex(random_bytes(32));
    $_SESSION['form_time'] = time();
}

echo json_encode(['token' => $_SESSION['form_token']]);