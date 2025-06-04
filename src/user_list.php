<?php
session_start();

if (!isset($_SESSION["username"]) || !($_SESSION["is_admin"] ?? false)) {
    die("접근 권한이 없습니다.");
}

$conn = new mysqli("db", "root", "root", "myapp");
if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$sql = "SELECT username, is_admin, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>회원 목록</title>
</head>
<body>
    <h2>전체 회원 목록</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>아이디</th>
            <th>가입일</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td>
                <?= htmlspecialchars($row["username"]) ?>
                <?= $row["is_admin"] ? "(관리자)" : "" ?>
            </td>
            <td><?= $row["created_at"] ?? "-" ?></td>
            <td>
            <?php if ($row["username"] !== $_SESSION["username"]): ?>
                <form action="delete_user.php" method="POST" onsubmit="return confirm('정말 삭제하시겠습니까?');" style="display:inline;">
                    <input type="hidden" name="username" value="<?= htmlspecialchars($row["username"]) ?>">
                    <input type="submit" value="삭제">
                </form>
            <?php else: ?>
                (본인)
            <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>

    <p><a href="main.php">메인으로 돌아가기</a></p>
</body>
</html>

<?php $conn->close(); ?>
