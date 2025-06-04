<?php
session_start();
if (!isset($_GET["id"])) {
    die("잘못된 접근입니다.");
}

$conn = new mysqli("db", "root", "root", "myapp");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$id = $_GET["id"];
$stmt = $conn->prepare("SELECT title, content, author FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("글이 존재하지 않습니다.");
}

if (!isset($_SESSION["username"]) || $_SESSION["username"] !== $post["author"]) {
    die("권한이 없습니다.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>글 수정</title>
</head>
<body>
    <h2>글 수정</h2>
    <form action="edit_process.php" method="POST">
        <input type="hidden" name="id" value="<?= $id ?>">
        <p>제목 : <input type="text" name="title" value="<?= htmlspecialchars($post["title"]) ?>" required></p>
        <p>내용 :<br>
            <textarea name="content" rows="10" cols="50" required><?= htmlspecialchars($post["content"]) ?></textarea>
        </p>
        <input type="submit" value="수정 완료">

    </form>
</body>
</html>
