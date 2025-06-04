<?php
session_start();
$conn = new mysqli("db", "root", "root", "myapp");

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT password, is_admin FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo "존재하지 않는 사용자입니다.";
} elseif (!password_verify($password, $row["password"])) {
    echo "비밀번호가 일치하지 않습니다.";
} else {
    $_SESSION["username"] = $username;
    $_SESSION["is_admin"] = $row["is_admin"];
    header("Location: main.php");
    exit;
}

$stmt->close();
$conn->close();
?>
