<?php require './header.php'; ?>
<?php
session_start();

unset($_SESSION['member']);

$_SESSION['original']['email'] = htmlspecialchars($_POST['email']); 



//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
$sql = $pdo -> prepare('select * from members where email=? and password=?');
$sql -> execute([$_REQUEST['email'], $_REQUEST['password']]);
foreach ($sql as $row) {
    $_SESSION['member']=[
        'id' => $row['id'], 'name_sei' => $row['name_sei'], 'name_mei' => $row['name_mei'],
        'gender' => $row['gender'], 'pref_name' => $row['pref_name'],
        'address' => $row['address'], 'password' => $row['password'],
        'email' => $row['email']];
}
if (isset($_SESSION['member'])){
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/top.php');
}else{
    $_SESSION['flash']['loginError'] = "※IDもしくはパスワードが間違っています";
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/login.php');
}


?>