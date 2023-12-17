<?php require './header.php'; ?>
<?php
session_start();

// セッションのflashメッセージをクリア
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);

// 過去のPOSTデータをクリア
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);


//ログインしている場合

//top.phpに遷移
if(isset($_SESSION['member'])){
  header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/top.php');
}
?>

<div class="login-wrapper main">

<form action="login-output.php" method="post">

<h1>ログイン</h1>

<table>
<tr>
  <td>メールアドレス（ID）</td>
  <td><input type="text" name="email" value="<?php echo isset($original['email']) ? $original['email'] : null;?>"></td>
</tr>
<tr>
  <td>パスワード</td>
  <td><input type="password" name="password"></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['loginError']) ? $flash['loginError'] : null ?></td>
</tr>
</table>
<br>
<input type="submit" value="ログイン">
</form>

<br>
<form method = "post" action = "top.php"><button>トップに戻る</button></form>

</div>

<?php require './footer.php'; ?>
