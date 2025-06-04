<?php
session_start();

$counter_file = "counter.txt";
if (!file_exists($counter_file)) {
    file_put_contents($counter_file, 0);
}
$count = (int)file_get_contents($counter_file);

$special_message = "";
if (isset($_POST['increase'])) {
    $count++;
    if($count == 10){
       $special_message = "<h3 style = 'color: crimson;'> 우주 최강 해킹 동아리 Cykor! </h3>";
       $count = 0;
    }
    file_put_contents($counter_file, $count);
}

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
        <a href="logout.php">로그아웃</a><br>
        <ol>
            <li> <a href="write.php">게시글 작성하기</a><br> </li>
            <li> <a href="my_post.php">내가 쓴 글 보기</a><br> </li> 
            <li> <a href="list.php"> 게시글 보기</a><br> </li>
                <?php if ($_SESSION["is_admin"] ?? false): ?>
                <li> <p><a href="user_list.php"> 회원 목록 보기</a></p> </li>
                <?php endif; ?>
        </ol>
        <img src="cykor.jpg" alt="우주 최강 해킹 동아리 Cykor" width="300">
        <h4>- Cykor -</h4>
        <form method="POST">
        <button type="submit" name="increase">눌러보세요</button>
        </form>
        <?php if ($special_message): ?>
            <?= $special_message ?>
        <?php endif; ?>
    </body>
</html>
