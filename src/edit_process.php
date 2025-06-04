<?php
session_start();

$conn = new mysqli("db", "root", "root", "myapp");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$id = $_POST["id"] ?? '';
$title = $_POST["title"] ?? '';
$content = $_POST["content"] ?? '';

if (trim($title) === '' || trim($content) === '') {
    echo "<script>alert('제목과 내용을 모두 입력해주세요.'); history.back();</script>";
    exit;
}

// 작성자 확인을 위해 author 조회
$stmt = $conn->prepare("SELECT author FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post || $_SESSION["username"] !== $post["author"]) {
    die("권한이 없습니다.");
}

// 수정 처리
$update_stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
$update_stmt->bind_param("ssi", $title, $content, $id);
$update_stmt->execute();

if ($update_stmt->affected_rows >= 0) {
    echo "<script>
        alert('수정 완료되었습니다.');
        location.href = 'list.php';
    </script>";
}
else {
    echo "<script>alert('수정 실패'); history.back();</script>";
}

$update_stmt->close();
$conn->close();
