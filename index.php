<?php

switch ($_SERVER['REQUEST_URI']) {
    case '/':
        include 'views/home.php';
        break;
    case '/users':
        include 'views/users.php';
        break;
    default:
        include '404.php';
        break;
}
?>