<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Lovation:login.php"); //바로 write로 들어오더라도 login으로 튕겨보내기
    exit;
}
?>

<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시글 작성</title>
    </head>
    <body>
        <h2>게시글 작성</h2>
        <form action="write_process.php" method="POST">
            <label>제목 : </label><br><br>
            <input type="txt" name="title" required><br><br><br>

            <label>내용 : </label><br>
            <txtarea name = "content" rows="10" cols = "50" required></txtarea><br><br>

            <input type="write" value="글 작성">
        </form>

        <p><a href="main.php"></a></p>
    </body>
</html>