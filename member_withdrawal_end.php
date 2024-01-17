<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];

if(isset($_SESSION['member'])){
    $sql = $pdo -> prepare('UPDATE members SET deleted_at = now() WHERE id = ?');
    $sql->execute([$member['id']]);
    unset($_SESSION['member']);
    unset($_SESSION['original']);
    unset($member);
    unset($original);
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/top.php');
    exit();
}else{
    echo "不正な処理です";
};
?>


<?php require './footer.php'; ?>