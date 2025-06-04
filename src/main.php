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
        <a href="logout.php">로그아웃웃</a><br>
        <img src="cykor.jpg" alt="우주 최강 해킹 동아리 Cykor" width="300">
        <h4>- 우주 최강 해킹 동아리 Cykor -</h4>
    </body>
</html>
