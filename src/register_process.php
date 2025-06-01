<?php
// DB 연결
$conn = new mysqli("db", "root", "root", "myapp");

// 연결 확인
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

// 입력값 받기
$username = $_POST['username'];
$password = $_POST['password'];
$hashed_pw = password_hash($password, PASSWORD_DEFAULT);

// SQL 준비 및 실행
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_pw);

if ($stmt->execute()) {
    echo "✅ 회원가입 성공!";
} else {
    echo "❌ 에러 발생: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
