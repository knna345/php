<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];


?>

<!--　ヘッダー　-->
<?php if (isset($_SESSION['member'])) : ?>
    <header>
        <div class="header-left">
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn logout-item"><a href="./top.php">トップに戻る</a></li>
            </ul>
        </nav>
    </header>

    <div class="main" style="text-align: center;">
    <h1>退会</h1>
    <p>退会しますか？</p>
    <br>
    <form method = "post" action = "member_withdrawal_end.php"><button>退会する</button></form>
    </div>
<?php else : ?>
    <header>
        <div class="header-left">
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn logout-item"><a href="./top.php">トップに戻る</a></li>
            </ul>
        </nav>
    </header>

    <div class="main" style="text-align: center;">
    <h1></h1>
    </div>
<?php endif; ?>

<?php require './footer.php'; ?>