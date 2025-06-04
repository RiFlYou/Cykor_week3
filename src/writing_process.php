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

$title = $_POST["title"];
$content = $_POST["content"];
$author = $_SESSION["usernmae"];

$stmt = $conn->prepare("Insert into posts (title, content, author) VALUESS(?, ? ?)");
$stmt->bind_param("sss", $title, $content, $author);

if($stmt->execute()){
    header("Location: list.php"); //글 다 썼으면 list로 보내기
    exit;
}
else{
    echo "글 저장에 오류가 발생했습니다 : ".$stmt->error;
}

$stmt->close();
$conn->close();
?>