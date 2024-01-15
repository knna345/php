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
///DBから~~~スレッドコメント~~~受け取り
// 1ページあたりのコメント数
$commentsPerPage = 5;

// 現在のページ番号を取得（デフォルトは1）
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
unset($_GET['page']);
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



//-----------------------------------------------
//メッセージのPOST
unset($flash);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //エラーメッセージ
    if(mb_strlen($_POST['comment']) === 0){
        $_SESSION['flash']['comment'] = '※コメントを入力してください';
    };
    $commentWithoutNewlines = str_replace(["\r", "\n"], '', $_POST['comment']);
    if(mb_strlen($commentWithoutNewlines , 'UTF-8') > 500){
        $_SESSION['flash']['commentLength'] = "※コメントは５００文字以内で入力してください";
    };
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
}
unset($_SESSION['flash']);



//DBに登録
$threadLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' . $thread['id'].'&page=' . $currentPage;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && !(isset($flash['comment'])) && !(isset($flash['commentLength']))){
    $pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
    $sqlDB = $pdo -> prepare('insert into comments values(null,?,?,?,now(),now(),null)');
    $sqlDB -> execute([$_SESSION['member']['id'], $thread['id'], $_POST['comment']]);
    header("Location: $threadLink");
    exit();
}



?>

<!---------------------------------------------------------------------->
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
echo '<div class="detail" style="display: table;width: 100%;margin-bottom: 20px;">
        <p style="display: table-cell; width:150px; text-align: right;"></p>
        <p class="detailLeft"  style="display: table-cell; text-align: center;">' . htmlspecialchars($totalComments) . 'コメント</p>
        <p class="detailRight" style="display: table-cell; width:150px; text-align: right;">'. $formattedDate . '</p>
    </div>';
?>

<!--　メイン　スレッドコメントページめくりリンク -->
<div style="display: table; width: 100%; margin-bottom: 20px;">
    <?php

    //前へ
    if ($currentPage > 1 ){
        $threadPrevPageLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' .  $thread['id'] .'&page=' . $currentPage -1;
        echo '<div style="display: table-cell; text-align: left;"> <a href=', $threadPrevPageLink ,'>＜ 前へ</a></div>';
    }elseif($currentPage == 1){
        echo '<p style="display: table-cell; text-align: left; color:gray;">＜ 前へ</p>';
    };


    //次へ
    if ($currentPage < $totalPages){
        $threadNextPageLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' . $thread['id'] .'&page=' . $currentPage +1;
        echo '<div style="display: table-cell; text-align: right;"><a href=', $threadNextPageLink, '>次へ ＞</a></div>';
    }elseif($currentPage > $totalPages || $currentPage == $totalPages){
        echo '<p style="display: table-cell; text-align: right; color:gray;">次へ ＞</p>';
    }


    ?>
</div>



<!--　メイン　スレッド詳細　-->

<div class="threadDetail content">

<?php
$formattedDate = date("Y.n.j g:i", strtotime($thread['created_at']));
echo '投稿者：' ,htmlspecialchars($threadMember['name_sei']), '　' ,htmlspecialchars($threadMember['name_mei']), '　' ,$formattedDate;
echo '<p>', nl2br(htmlspecialchars($thread['content'])) ,'</p>';
?>

</div>


<!--　メイン　スレッドコメント５件ずつ表示 -->
<div class="threadComments">

<?php
if ($totalComments >= 1){
    //データベース接続、コメント取得
    $sqlComments = $pdo -> prepare('SELECT comments.*, members.name_sei, members.name_mei FROM comments 
                                    JOIN members ON comments.member_id = members.id WHERE thread_id = ? ORDER BY created_at ASC LIMIT ?,5 ');
    $sqlComments->bindValue(1, $thread['id'], PDO::PARAM_INT);
    $sqlComments->bindValue(2, $offset, PDO::PARAM_INT);
    $sqlComments->execute();
    $i = $offset + 1;
    foreach ($sqlComments as $com) {
        $formattedDate = date("Y.n.j H:i", strtotime($com['created_at']));
        //コメ投稿者情報-------
        echo '<p>',$i, '.　', htmlspecialchars($com['name_sei']), '　', htmlspecialchars($com['name_mei']), '　', $formattedDate, '</p>';
        //コメント-------
        echo '<p class="comment-text">', nl2br(htmlspecialchars($com['comment'])), '</p>';

        //いいねボタン------------------------
        $threadCommentLike = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail_like.php?id=' .  $thread['id'] . '&comId=' .  $com['id'];
        $threadCommentLikeDelete = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail_likeDelete.php?id=' .  $thread['id'] . '&comId=' .  $com['id'];

        $likeCount = $pdo->prepare('SELECT count(*) as total from likes where comment_id = ?');
        $likeCount -> execute([$com['id']]);
        $result = $likeCount -> fetch(PDO::FETCH_ASSOC);
        $totallikes = $result['total'];

        $like = $pdo->prepare('SELECT count(*) as total from likes where comment_id = ? and member_id = ?');
        $like -> execute([$com['id'], $member['id']]);
        $resultlike = $like -> fetch(PDO::FETCH_ASSOC);
        $loginlike = $resultlike['total'];

        if((isset($member['id'])) &&  $loginlike === "0"){ 
            //ログインしている場合　かつ　押していない場合
            echo '<p style="text-align: right;"><a href="' . $threadCommentLike . '"><i class="fa-regular fa-heart"></i>　'. $totallikes.'</p>';
        }elseif((isset($member['id'])) &&  $loginlike === "1"){ 
            //ログインしている場合　かつ　すでに押している場合
            echo '<p style="text-align: right;"><a href="' . $threadCommentLikeDelete . '"><i class="fa-solid fa-heart" style="color: red;"></i>　'. $totallikes.'</p>';
        }else{ 
            //ログアウトの場合登録フォーム
            $memberRegistLink = 'https://ik1-219-79869.vs.sakura.ne.jp/php/member_regist.php';
            echo '<p style="text-align: right;"><a href="' . $memberRegistLink . '"><i class="fa-regular fa-heart"></i>　'. $totallikes.'</p>';
        }

        //アンダーライン-------
        echo '<hr size="1px" width="100%" align=";center">';
        $i = $i + 1;
    }
}

?>

</div>

<!--　メイン　スレッドコメントページめくりリンク -->
<div style="display: table; width: 100%; margin-bottom: 20px; margin-top: 30px;">
    <?php

    //前へ
    if ($currentPage > 1 ){
        $threadPrevPageLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' .  $thread['id'] .'&page=' . $currentPage -1;
        echo '<div style="display: table-cell; text-align: left;"> <a href=', $threadPrevPageLink ,'>＜ 前へ</a></div>';
    }elseif($currentPage == 1){
        echo '<p style="display: table-cell; text-align: left; color:gray;">＜ 前へ</p>';
    };


    //次へ
    if ($currentPage < $totalPages){
        $threadNextPageLink = 'http://ik1-219-79869.vs.sakura.ne.jp/php/thread_detail.php?id=' . $thread['id'] .'&page=' . $currentPage +1;
        echo '<div style="display: table-cell; text-align: right;"><a href=', $threadNextPageLink, '>次へ ＞</a></div>';
    }elseif($currentPage > $totalPages || $currentPage == $totalPages){
        echo '<p style="display: table-cell; text-align: right; color:gray;">次へ ＞</p>';
    }


    ?>
</div>

<!--　メイン　コメント投稿フォーム || ログイン時のみ表示　-->
<div class="comment">

<?php if(isset($member['id'])) : ?>

<form action="" method="post">
    <textarea name="comment" rows="10" cols="70"></textarea>
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
