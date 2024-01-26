<?php require '../header.php'; ?>

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

echo $original['name_sei'];

// POSTされたトークンとセッション変数のトークンの比較
if($token != "" && $token == $session_token) {
    $pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
    $sql = 'UPDATE members SET name_sei = :name_sei, name_mei = :name_mei, gender = :gender, pref_name = :pref_name, address = :address';

    if(isset($original['password'])){
        $sql .= " , password = :password";
    }

    $sql .= " , email = :email, updated_at = now() WHERE id = :id";

    $update = $pdo->prepare($sql);

    $update->bindParam(':name_sei', $original['name_sei'], PDO::PARAM_STR);
    $update->bindParam(':name_mei', $original['name_mei'], PDO::PARAM_STR);
    $update->bindParam(':gender', $original['gender'], PDO::PARAM_INT);
    $update->bindParam(':pref_name', $original['pref_name'], PDO::PARAM_STR);
    $update->bindParam(':address', $original['address'], PDO::PARAM_STR);
    if(isset($original['password'])){
        $update->bindParam(':password', $original['password'], PDO::PARAM_STR);
    }
    $update->bindParam(':email', $original['email'], PDO::PARAM_STR);
    $update->bindParam(':id', $_SESSION['edit']['id'], PDO::PARAM_INT);

    $update->execute();
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php');
}else{
    echo "不正な登録処理です";
};


?>


<?php require '../footer.php'; ?>