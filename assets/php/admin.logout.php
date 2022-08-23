<?php
require_once 'partials/_sessionStart.php';
unset($_SESSION['username']);
unset($_SESSION['isLoggedIn']);
unset($_SESSION);
session_unset();
session_destroy();
header('location:login.php');