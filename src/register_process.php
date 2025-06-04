<?php
$conn = new mysqli("db", "root", "root", "myapp");

if ($conn->connect_error) {
    die("DB 연결 실패: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$hashed_pw = password_hash($password, PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT * FROM users WHERE username = ?");
$check->bind_param("s", $username);
$check->execute();
$check_result = $check->get_result();

if ($check_result->num_rows > 0) {
    echo "<script>
        alert('이미 존재하는 아이디입니다.');
        history.back();
    </script>";
    exit;
}
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hashed_pw);

if ($stmt->execute()) {
    echo "회원가입 성공!<br>"; 
    echo "<p><a href='main.php'>메인 화면으로 이동</a></p>";
}
else {
    echo "에러 발생: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
