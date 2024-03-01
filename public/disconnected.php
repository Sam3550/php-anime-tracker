<?php 
include("partials/header.php");

if (isset($_SESSION["username"])) {
    unset($_SESSION);
    session_destroy();
    header('Location: login.php');
} else {
    echo "vous n'etes pas connecté";
}