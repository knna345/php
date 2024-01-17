<?php require '../header.php'; ?>
<?php
session_start();

unset($_SESSION['admin']);

$_SESSION['original']['adLogin_id'] = htmlspecialchars($_POST['adLogin_id']); 



//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
$sql = $pdo -> prepare('SELECT * from administers where login_id = ? and password = ? and deleted_at is NULL');
$sql -> execute([$_REQUEST['adLogin_id'], $_REQUEST['adPassword']]);
foreach ($sql as $row) {
    $_SESSION['admin']=[
        'id' => $row['id'], 'name' => $row['name'], 
        'login_id' => $row['login_id'], 'password' => $row['password'],];
}
if (isset($_SESSION['admin'])){
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/admin/top.php');
}else{
    $_SESSION['flash']['adLoginError'] = "※IDもしくはパスワードが間違っています";
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/admin/login.php');
}


?>