<?php
session_start();
if(!isset($_GET["id"])){
    echo "잘못된 접근입니다";
    exit;
}

$conn = new mysqli("db", "root", "root", "myapp");
if($conn->connect_error){
    die("DB 연결 실패". $conn->connect_error);
}

$id = $_GET["id"];
$stmt = $conn->prepare("Select title, content, author, created_at from posts where id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();  
$post = $result->fetch_assoc();

if(!$post){
    echo "게시글이 존재하지 않습니다.";
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?=htmlspecialchars($post["title"])?></title>
    </head>
    <body>
        <h2><?= htmlspecialchars($post["title"])?></h2>
        <p><strong> 글쓴이 : </strong><?= htmlspecialchars($post["author"])?></p>
        <p><strong> 작성일:</strong> <?= $post["created_at"] ?></p>
        <hr>
        <p><?= nl2br(htmlspecialchars($post["content"])) ?></p>
        <p><a href="list.php"> 목록 </a></p>

        <?php if (isset($_SESSION['username'])): ?>
            <?php if ($_SESSION['username'] === $post['author']): ?>
                <p><a href="edit.php?id=<?= $id ?>"> 수정</a></p>
            <?php endif; ?>

            <?php if ($_SESSION['username'] === $post['author'] || $_SESSION['username'] === 'admin'): ?>
                <form action="delete_process.php" method="POST" onsubmit="return confirm('정말 삭제하시겠습니까?');">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <input type="submit" value= "삭제">
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </body>
</html>

<?php
$stmt->close();
$conn->close();
?>