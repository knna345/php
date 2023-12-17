<?php require './header.php'; ?>

<?php

session_start();

// POSTされたトークンを取得
$token = isset($_POST["token"]) ? $_POST["token"] : "";

// セッション変数のトークンを取得
$session_token = isset($_SESSION["token"]) ? $_SESSION["token"] : "";

// セッション変数のトークンを削除
unset($_SESSION["token"]);



$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);




// POSTされたトークンとセッション変数のトークンの比較
if($token != "" && $token == $session_token) {
    $pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
    $sql = $pdo -> prepare('insert into threads values(null,?,?,?,now(),now(),null)');
    $sql -> execute([$_SESSION['member']['id'], $original['title'],  $original['content']]);
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/thread.php');
}else{
    echo "不正な登録処理です";
};



?>


<?php require './footer.php'; ?>