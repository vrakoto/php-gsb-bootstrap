<?php
require_once 'auth.php';

if (is_connect()) {
    unset($_SESSION['admin']);
    header('Location: index.php');
}
exit();