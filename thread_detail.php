<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];


//スレッドIDをゲットする
$threadId = $_GET['id'];

//DBからスレッド情報受け取り
$sql = $pdo -> prepare('select * from threads where id=?');
$sql -> execute([$threadId]);
foreach ($sql as $row) {
    $_SESSION['thread']=[
        'id' => $row['id'], 'member_id' => $row['member_id'], 'title' => $row['title'],
        'content' => $row['content'], 'created_at' => $row['created_at']];
}

$thread = isset($_SESSION['thread']) ? $_SESSION['thread'] : [];
unset($_SESSION['thread']);

//DBから会員情報受け取り
$sql = $pdo -> prepare('select * from members where id=?');
$sql -> execute([$thread['member_id']]);
foreach ($sql as $row) {
    $_SESSION['threadMember']=[
        'id' => $row['id'], 'name_sei' => $row['name_sei'], 'name_mei' => $row['name_mei']];
}

$threadMember = isset($_SESSION['threadMember']) ? $_SESSION['threadMember'] : [];
unset($_SESSION['threadMember']);

?>


<!--　ヘッダー　-->

<header>
    <div class="header-left">
        
    </div>
    <nav class="nav">
        <ul class="menu-group">
            <li class="btn login-item"><a href="./thread.php">スレッド一覧に戻る</a></li>
        </ul>
    </nav>
</header>

<!--　メイン　-->
<div class="main">

<!--　メイン　スレッドタイトル　-->
<?php 

echo '<p class="centered">' .htmlspecialchars($thread['title']) . '</p>';
$formattedDate = date("Y/m/d H:i", strtotime($thread['created_at']));
echo '<p style="text-align: right; padding-right: 50px;">', $formattedDate, '</p>';

?>


<!--　メイン　スレッド詳細　-->

<div class="threadDetail content">

<?php

$formattedDate = date("Y.m.d H:i", strtotime($thread['created_at']));
echo '投稿者：' ,htmlspecialchars($threadMember['name_sei']), '　' ,htmlspecialchars($threadMember['name_mei']), '　' ,$formattedDate;
echo '<p>', nl2br(htmlspecialchars($thread['content'])) ,'</p>';
?>

</div>

<!--　メイン　コメント投稿フォーム || ログイン時のみ表示　-->
<div class="comment">

<?php if (isset($_SESSION['member'])) : ?>

<form action="thread_detail.php" method="post">

<textarea name="comment" rows="10" cols="75" wrap=”hard”></textarea>
<div class="formbtn">
<input type="submit" value="コメントする">
</div>

</form>

<?php endif; ?>
</div>

<!--メインdivの終わり-->
</div> 

<?php require './footer.php'; ?>
