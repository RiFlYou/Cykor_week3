<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("db", "root", "root", "myapp");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$username = $_SESSION["username"];

$stmt = $conn->prepare("SELECT id, title, created_at FROM posts WHERE author = ? ORDER BY created_at DESC");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>내가 쓴 글</title>
</head>
<body>
    <h2>내가 쓴 글 목록</h2>
    <table border="1">
        <tr>
            <th>글 번호</th>
            <th>제목</th>
            <th>작성일</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row["id"] ?></td>
            <td><a href="view.php?id=<?= $row["id"] ?>"><?= htmlspecialchars($row["title"]) ?></a></td>
            <td><?= $row["created_at"] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <p><a href="main.php">메인으로 돌아가기</a></p>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
