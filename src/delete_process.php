<?php
session_start();

if (!isset($_SESSION["username"])) {
    die("로그인이 필요합니다.");
}

if (!isset($_POST["id"])) {
    die("잘못된 요청입니다.");
}

$conn = new mysqli("db", "root", "root", "myapp");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$id = $_POST["id"];
$username = $_SESSION["username"];

//작성자 검문문
$stmt = $conn->prepare("SELECT author FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("게시글이 존재하지 않습니다.");
}

if ($username !== $post["author"] && $username !== $_SESSION["is_admin"]) {
    die("삭제 권한이 없습니다.");
}

$del_stmt = $conn->prepare("DELETE FROM posts WHERE id = ?");
$del_stmt->bind_param("i", $id);
$del_stmt->execute();

if ($del_stmt->affected_rows > 0) {
    echo "<script>alert('삭제되었습니다.'); location.href='list.php';</script>";
} else {
    echo "<script>alert('삭제 실패'); history.back();</script>";
}

$del_stmt->close();
$conn->close();
?>
