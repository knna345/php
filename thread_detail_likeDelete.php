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



//DBから削除
$threadLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' . $threadId.'&page=' . $_SESSION['currentPage'];
$sql = $pdo -> prepare('DELETE from likes where comment_id = ? and member_id = ?');
$sql -> execute([$commentId , $member['id']]);
header("Location: $threadLink");
exit();

?>




<?php require './footer.php'; ?>