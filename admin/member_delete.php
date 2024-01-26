<?php require '../header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];

//-------------------------------
//会員IDの取得
$getId = isset($_GET['id']) ? $_GET['id'] : [];
unset($_SESSION['edit']);



//-------------------------------
//データベースにソフトデリート
if(isset($admin)){
    $sql = $pdo -> prepare('UPDATE members SET deleted_at = now() WHERE id = ?');
    $sql->execute([$getId]);
    unset($_SESSION['member']);
    unset($_SESSION['original']);
    unset($member);
    unset($original);
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php');
    exit();
}else{
    echo "不正な処理です";
};
?>


<?php require '../footer.php'; ?>