<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>회원가입</title>
</head>
<body>
    <h2>회원가입</h2>
    <form action="register_process.php" method="POST">
        <label>아이디: </label>
        <input type="text" name="username" required><br><br>
        
        <label>비밀번호: </label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="가입하기">
    </form>
</body>
</html>
