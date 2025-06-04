<?php
$conn = new mysqli("db", "root", "root", "myapp");

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$hashed_pw = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_pw);

if ($stmt->execute()) {
    echo "회원가입 성공!";
} else {
    echo "에러 발생: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
