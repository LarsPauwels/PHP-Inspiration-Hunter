<?php
    require_once('bootstrap/bootstrap.php');
    $user = new User;
    $user->logout();
    header('Location: login');
?>