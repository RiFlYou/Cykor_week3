<?php

$username = $_POST['username'];
$password = $_POST['password'];
$hashed_pw = password_hash($password, PASSWORD_DEFAULT);

echo "입력된 아이디: " . htmlspecialchars($username) . "<br>";
echo "암호화된 비밀번호: " . $hashed_pw;
?>