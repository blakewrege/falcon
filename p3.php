<?php 
session_start(); 
$name = $_SESSION['name'];
$email = $_SESSION['email'];
echo "hello ".$name." your email is ".$email;
?>
