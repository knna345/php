<?php require '../header.php'; ?>
<?php

session_start();



//ログインしている場合
$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];

//-------------------------------
//会員IDの取得
$getId = isset($_GET['id']) ? $_GET['id'] : [];
unset($_SESSION['edit']);

//会員IDに基づいてデータベースから受け取り
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');
$sql = $pdo -> prepare('SELECT * from members where id = ? and deleted_at is NULL');
$sql -> execute([$_GET['id']]);
foreach ($sql as $row) {
    $_SESSION['edit']=[
        'id' => $row['id'], 'name_sei' => $row['name_sei'], 'name_mei' => $row['name_mei'], 
        'gender' => $row['gender'], 'pref_name' => $row['pref_name'],
        'address' => $row['address'], 'password' => $row['password'],
        'email' => $row['email']];
}

//表示用データ置き換え（性別）
switch ($_SESSION['edit']['gender']){
    case '1':
        $gender = '男性';
        break;

    case '2':
        $gender = '女性';
        break;

}
?>

<?php if (isset($_SESSION['admin'])) : //ログイン時 ?>
<!---------------------------------------　ヘッダー　------------------------------------------>
<header>
        <div class="header-left">
            会員編集
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn"><a href="./member.php">一覧へ戻る</a></li>
            </ul>
        </nav>
</header>


<!---------------------------------------　会員情報詳細画面　------------------------------------------>

<div class="member_confirm-wrapper main" style=" margin-top: 50px; ">

<table width="500" style=" margin: auto;">
<tr>
    <td>ID</td>
    <td><?php echo $_SESSION['edit']['id'] ?></td></tr>
<tr></tr>
<tr>
    <td>氏名</td>
    <td><?php echo htmlspecialchars($_SESSION['edit']['name_sei'])?>　<?php echo htmlspecialchars($_SESSION['edit']['name_mei'])?></td></tr>
<tr></tr>
<tr>
    <td>性別</td>
    <td><?php echo $gender ?></td></tr>
<tr></tr>
<tr>
    <td>住所</td>
    <td><?php echo $_SESSION['edit']['pref_name'] ?><?php echo htmlspecialchars($$_SESSION['edit']['address'])?></td></tr>
<tr></tr>
<tr>
    <td>パスワード</td>
    <td>セキュリティのため非表示</td></tr>
<tr></tr>
<tr>
    <td>メールアドレス　</td>
    <td><?php echo htmlspecialchars($_SESSION['edit']['email'])?></td></tr>
</table>

</div>

<!----------------------------------------　会員 編集・削除 ボタン　------------------------------------------>
<?php
$editPage = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member_edit.php?id=' . $_SESSION['edit']['id'];
$deletePage = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member_delete.php?id=' . $_SESSION['edit']['id'];
?>

<nav style="text-align: center; margin-top: 20px;">
    <ul style="list-style-type: none; padding: 0; display: flex; justify-content: center;">
        <li class="btn" style="margin-right: 20px;"><a href='<?php echo $editPage; ?>'>編集</a></li>
        <li class="btn"><a href='<?php echo $deletePage; ?>'>削除</a></li>
    </ul>
</nav>


<?php endif; ?>

<?php require '../footer.php'; ?>