<?php
//load session
//deleting session variables
session_start();
if(isset($_SESSION['username'])){
    session_unset();
    //destroying session 
    unset($_SESSION['pl_name']);
    unset($_SESSION['cart']);
    unset($_SESSION['username']);
    session_destroy();
    header('Location:http://localhost/Kun-Gadi/WebApp/index.php');
}else{
    header('Location:http://localhost/Kun-Gadi/WebApp/index.php');

}
