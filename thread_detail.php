<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];



//-----------------------------------------------
//一覧ページからスレッドIDをゲットする
$threadId = isset($_GET['id']) ? $_GET['id'] : [];
unset($_GET['id']);


//DBから~~~スレッド情報~~~受け取り
$sqlThread = $pdo -> prepare('select * from threads where id=?');
$sqlThread -> execute([$threadId]);
foreach ($sqlThread as $row) {
    $_SESSION['thread']=[
        'id' => $row['id'], 'member_id' => $row['member_id'], 'title' => $row['title'],
        'content' => $row['content'], 'created_at' => $row['created_at']];
}

$thread = isset($_SESSION['thread']) ? $_SESSION['thread'] : [];
unset($_SESSION['thread']);


//DBから~~~投稿主の会員情報~~~受け取り
$sqlThreadMember = $pdo -> prepare('select * from members where id=?');
$sqlThreadMember -> execute([$thread['member_id']]);
foreach ($sqlThreadMember as $row) {
    $_SESSION['threadMember']=[
        'id' => $row['id'], 'name_sei' => $row['name_sei'], 'name_mei' => $row['name_mei']];
}

$threadMember = isset($_SESSION['threadMember']) ? $_SESSION['threadMember'] : [];
unset($_SESSION['threadMember']);


//-----------------------------------------------
//メッセージのPOST

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //エラーメッセージ
    if(mb_strlen($_POST['comment']) === 0){
        $_SESSION['flash']['comment'] = '※コメントを入力してください';
    }elseif (mb_strlen($_POST['comment'] , "UTF-8") > 500) {
        $_SESSION['flash']['commentLength'] = "※コメントは５００文字以内で入力してください";
    };
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
}
unset($_SESSION['flash']);


//DBに登録
$threadLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' . $thread['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !(isset($flash['comment'])) && !(isset($flash['commentLength']))){
    $pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
    $sqlDB = $pdo -> prepare('insert into comments values(null,?,?,?,now(),now(),null)');
    $sqlDB -> execute([$_SESSION['member']['id'], $thread['id'], $_POST['comment']]);
    header("Location: $threadLink");
    exit();
}


//-----------------------------------------------
///DBから~~~スレッドコメント~~~受け取り
// 1ページあたりのコメント数
$commentsPerPage = 5;

// 現在のページ番号（デフォルトは1）
$currentPage = isset($_SESSION['currentPage']) ? $_SESSION['currentPage'] : 1;
$_SESSION['currentPage'] = $currentPage;

// コメントの開始位置
$offset = ($currentPage - 1) * $commentsPerPage;



//-----------------------------------------------
//DBから総コメント数を取得
$sqlCount = $pdo->prepare('select count(*) as total from comments where thread_id = ?');
$sqlCount -> execute([$thread['id']]);
$result = $sqlCount -> fetch(PDO::FETCH_ASSOC);

$totalComments = $result['total'];


//-----------------------------------------------
// 総ページ数を計算、「次へ」「前へ」
$totalPages = ceil($totalComments / $commentsPerPage);




?>

<!-------------------------------------------------->
<!-------------------------------------------------->
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

<!-------------------------------------------------->
<!--　メイン　-->
<div class="main">

<!--　メイン　スレッドタイトル　-->
<?php 

echo '<p class="centered">' .htmlspecialchars($thread['title']) . '</p>';
$formattedDate = date("n/j/y g:i", strtotime($thread['created_at']));
echo '<div class="detail" style="display: table;width: 100%;margin-bottom:20px;">
        <p style="display: table-cell;width:150px;text-align: right;"></p>
        <p class="detailLeft"  style="display: table-cell;text-align: center;">' . htmlspecialchars($totalComments) . 'コメント</p>
        <p class="detailRight" style="display: table-cell;width:150px;text-align: right;">'. $formattedDate . '</p>
    </div>';
?>


<!--　メイン　スレッド詳細　-->

<div class="threadDetail content">

<?php
$formattedDate = date("Y.n.j g:i", strtotime($thread['created_at']));
echo '投稿者：' ,htmlspecialchars($threadMember['name_sei']), '　' ,htmlspecialchars($threadMember['name_mei']), '　' ,$formattedDate;
echo '<p>', nl2br(htmlspecialchars($thread['content'])) ,'</p>';
?>

</div>

<!--　メイン　スレッドコメント５件ずつ表示　｜　表示されない、かつコメントがある場合コメントフォームが表示されない　-->
<div class="threadComments">

<?php
if ($totalComments >= '1'){
    //データベース接続、コメント取得 わからん！
    $sqlComments = $pdo -> prepare('select * from comments where thread_id = ? ORDER BY created_at DESC LIMIT 5 OFFSET ?');
    $sqlComments -> execute([$thread['id'], $offset]);
    foreach ($sqlComments as $row) {
        echo $row['comment'];
    }
    foreach ($_SESSION['comments'] as $key) {
        echo  $key['comment'];
    };
}
?>

</div>

<!--　メイン　コメント投稿フォーム || ログイン時のみ表示　-->
<div class="comment">

<?php if(isset($_SESSION['member'])) : ?>

<form action="" method="post">
    <textarea name="comment" rows="10" cols="75" wrap="hard"></textarea>
    <!-- エラーメッセージがセットされている場合に表示 -->
        <?php echo isset($flash['comment']) ? '<br>'.$flash['comment'] : null ?>
        <?php echo isset($flash['commentLength']) ? '<br>'.$flash['commentLength'] : null ?>

    <div class="formbtnright">
    <input type="submit" value="コメントする">
    </div>

</form>

<?php endif; ?>
</div>

<!--メインdivの終わり-->
</div> 

<?php require './footer.php'; ?>
