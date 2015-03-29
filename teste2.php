<?php

// Apenas para testes do código
session_start();
$_SESSION['loggedin'] = true;
$_COOKIE['Loggedin'] = false;

//

$loginSession = (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true);
$loginCookie = (isset($_COOKIE['Loggedin']) && $_COOKIE['Loggedin'] == true);

if ($loginSession || $loginCookie) {
    header("Location: http://www.google.com");
    exit();
}


?>