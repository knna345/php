<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');

//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];

?>


<!--　ヘッダー　-->

<header>
    <div class="header-left">
        
    </div>
    <nav class="nav">
        <ul class="menu-group">
            <?php if (isset($_SESSION['member'])) : ?>
            <li class="btn login-item"><a href="./thread_regist.php">新規スレッド作成</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>


<!--　メイン　スレッド一覧　-->

<div class="thread main">



</div>

<?php require './footer.php'; ?>