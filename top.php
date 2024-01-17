<?php require './header.php'; ?>
<?php

session_start();

//ログインしている場合

$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];

?>

<!--　ヘッダー　-->

<?php if (isset($_SESSION['member'])) : //ログイン時 ?>
    <header>
        <div class="header-left">
            <?php echo 'ようこそ',$member['name_sei'],$member['name_mei'],'様'?>
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn login-item"><a href="./thread.php">スレッド一覧</a></li>
                <li class="btn login-item"><a href="./thread_regist.php">新規スレッド作成</a></li>
                <li class="btn login-item"><a href="./logout.php">ログアウト</a></li>
            </ul>
        </nav>
    </header>
    <footer>
        <div class="withdrawal-button btn">
            <a href="member_withdrawal.php">退会</a>
        </div>
    </footer>
<?php else : //ログアウト時 ?>
    <header>
        <div class="header-left">
            
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn logout-item"><a href="./thread.php">スレッド一覧</a></li>
                <li class="btn logout-item"><a href="./member_regist.php">新規会員登録</a></li>
                <li class="btn logout-item"><a href="./login.php">ログイン</a></li>
            </ul>
        </nav>
    </header>
<?php endif; ?>

<div class="main">

</div>

<?php require './footer.php'; ?>