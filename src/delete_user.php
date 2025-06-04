<?php
session_start();

if (!isset($_SESSION["username"]) || !($_SESSION["is_admin"] ?? false)) {
    die("접근 권한이 없음.");
}

if (!isset($_POST["username"])) {
    die("잘못된 요청.");
}

$username_to_delete = $_POST["username"];

if ($username_to_delete === $_SESSION["username"]) {
    die("자기 자신은 삭제할 수 없습니다.");
}

$conn = new mysqli("db", "root", "root", "myapp");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $username_to_delete);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('회원 삭제 완료'); location.href='user_list.php';</script>";
} else {
    echo "<script>alert('삭제 실패'); history.back();</script>";
}

$stmt->close();
$conn->close();
?>
