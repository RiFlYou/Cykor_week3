<?php
session_start();
$conn = new mysqli("db", "root", "root", "myapp");

if($conn ->connect_error){
    die("DB 연결 실패: ". $conn ->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT password FROM users where username = ?");
$stmt ->bind_param("s", $username);
$stmt -> execute();
$stmt -> store_result();

if($stmt->num_rows === 1){
    $stmt -> bind_result($hased_pw);
    $stmt -> fetch();

    if(password_verify($password, $hased_pw)){
        $_SESSION['username'] = $username;
        header("Location: main.php"); 
        exit;
    }
    else{ 
        echo "잘못된 비밀번호입니다.";
    }
}
else{
    echo "존재하지 않는 사용자입니다.";
}

$stmt->close();
$conn->close();
?>