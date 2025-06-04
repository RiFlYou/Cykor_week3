<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: login.php"); //마찬가지로 로그인 안 하면 바로 로그인으로 보내버리기
    exit;
}

$conn = new mysqli("db", "root", "root", "myapp");
if($conn->connect_error){
    die("DB 연결 실패 : ". $conn->connect_error);
}

$title = $_POST["title"] ?? '';
$content = $_POST["content"] ?? '';
$author = $_SESSION["username"];

if (trim($title) === '' || trim($content) === '') {
    echo "<script>
        alert('제목과 내용을 모두 입력해주세요.');
        history.back();
    </script>";
    exit;
}

$stmt = $conn->prepare("Insert into posts (title, content, author) VALUES(?, ?, ?)");
$stmt->bind_param("sss", $title, $content, $author);

if($stmt->execute()){
    echo "<script>
        alert('게시글이 성공적으로 작성되었습니다.');
        window.location.href = '/list.php';
    </script>";
    exit;
}
else {
    $error = addslashes($stmt->error);
    echo "<script>
        alert('오류 : {$error}');
        history.back();
    </script>";
}

$stmt->close();
$conn->close();
?>