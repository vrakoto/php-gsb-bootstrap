<?php

function is_connect()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    return !empty($_SESSION['admin']);
}

function redirect()
{
    if (!is_connect()) {
        header('Location: /login.php');
        exit();
    }
}