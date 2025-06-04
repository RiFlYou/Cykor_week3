<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Main Page</title>
    </head>
    <body>
        <h2>안녕하세요, <?php echo htmlspecialchars($_SESSION["username"]); ?>님!</h2>
        <p>페이지에 방문하신 걸 환영합니다!!</p>
        <a href="logout.php">로그아웃웃</a>
    </body>
</html>
