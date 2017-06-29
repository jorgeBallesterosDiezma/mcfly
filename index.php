<?php
    require_once "apimcfly.php"; 
header('Content-Type: application/JSON');                
/*
session_start();
$_SESSION['usuario']='jorge';
$_SESSION['pass']='1234';*/
$Mcfly = new flyAPI();
$Mcfly ->API();
 

?>
