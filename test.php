<?php
$password = "password";
echo $password;
$pass = password_hash($password, PASSWORD_ARGON2ID);
echo $pass;
echo $password;
?>