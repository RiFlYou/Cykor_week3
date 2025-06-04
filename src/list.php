<?php
session_start();
$conn = new mysqli("db", "root", "root", "myapp");

if($conn->connect_error){
    die("DB 연결 실패: " . $conn->connect_error);
}

$sql = "SELECT id, title, author, created_at FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>게시글 목록</title>
</head>
<body>
    <h2>게시글 목록</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>글 번호</th>
            <th>제목</th>
            <th>글쓴이</th>
            <th>작성 시간</th>
            <th>관리</th> 
        </tr>
        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td>
                <a href="view.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['title']) ?></a>
            </td>
            <td><?= htmlspecialchars($row['author']) ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>
                <?php if (isset($_SESSION["username"]) && 
                          ($_SESSION["username"] === $row["author"] || ($_SESSION["is_admin"] ?? false))): ?>
                    <a href="edit.php?id=<?= $row['id'] ?>">수정</a>
                    <form action="delete_process.php" method="POST" style="display:inline;" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <input type="submit" value="삭제">
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <?php if (isset($_SESSION["username"])): ?>
        <p><a href="write.php">글쓰기</a></p>
    <?php else: ?>
        <p><a href="login.php">로그인</a></p>
    <?php endif; ?>

    <p><a href="main.php">메인 화면으로</a></p>
</body>
</html>

<?php $conn->close(); ?>
