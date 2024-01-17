<?php require '../header.php'; ?>
<?php

session_start();


//ログインしている場合

$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];

?>

<!--　ヘッダー　-->

<?php if (isset($_SESSION['admin'])) : //ログイン時 ?>
    <header>
        <div class="header-left">
            掲示板管理画面メインメニュー
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="login-item" style=" display:inline-block; text-align: center; margin-right: 20px; font-size: 20px;"><?php echo 'ようこそ',$admin['name'],'さん'?></li>
                <li class="btn login-item"><a href="./logout.php">ログアウト</a></li>
            </ul>
        </nav>
    </header>
<?php else : //ログアウト時 ?>
    <header>
        <div class="header-left">
            
        </div>
        <nav class="nav">
            <ul class="menu-group">
            </ul>
        </nav>
    </header>
<?php endif; ?>

<div class="main">

</div>


<?php require '../footer.php'; ?>