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
    $sql = $pdo -> prepare('insert into members values(null,?,?,?,?,?,?,?,now(),now(),null)');
    $sql -> execute([
        $original['name_sei'], $original['name_mei'],  $original['gender'], 
        $original['pref_nameName'],  $original['address'], $original['password'], $original['email']
    ]);
    echo '<div class= "main"'>
    echo '<h1>会員登録完了</h1>';
    echo '<p>会員登録が完了しました。</p>';
    echo '<form method = "post" action = "top.php"><button>トップに戻る</button></form>';
    echo '</div>'
}else{
    echo "不正な登録処理です";
};


?>


<?php require './footer.php'; ?>