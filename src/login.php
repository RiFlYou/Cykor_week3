<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>로그인</title>
    </head>
    <body>
        <h2>로그인</h2>
        <form action="login_process.php" method="POST">
        <label for="username">아이디:</label>
        <input type="text" name="username" required><br><br>
        <label for="password">비밀번호 : </label>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="로그인">
        </form>
    </body>
</html>