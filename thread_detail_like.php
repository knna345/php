<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];


//-----------------------------------------------
//スレッド詳細ページからスレッドIDをゲットする
$threadId = isset($_GET['id']) ? $_GET['id'] : [];
unset($_GET['id']);


//スレッド詳細ページからコメントIDをゲットする
$commentId = isset($_GET['comId']) ? $_GET['comId'] : [];
unset($_GET['comId']);


//DBに登録
$threadLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' . $threadId.'&page=' . $_SESSION['currentPage'];
$sql = $pdo -> prepare('insert into likes values(null,?,?)');
$sql -> execute([$member['id'], $commentId]);
header("Location: $threadLink");
exit();

?>




<?php require './footer.php'; ?>