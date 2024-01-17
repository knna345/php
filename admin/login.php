<?php require '../header.php'; ?>
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
if(isset($_SESSION['admin'])){
  header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/admin/top.php');
}
?>

<div class="login-wrapper main">

<form action="https://ik1-219-79869.vs.sakura.ne.jp/php/admin/login-output.php" method="post">

<h1>管理画面</h1>

<table>
<tr>
  <td>ログインID</td>
  <td><input type="text" name="adLogin_id" minlength="7" maxlength="10" value="<?php echo isset($original['adLogin_id']) ? $original['adLogin_id'] : null;?>"></td>
</tr>
<tr>
  <td>パスワード</td>
  <td><input type="password" name="adPassword" minlength="8" maxlength="20"></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['adLoginError']) ? $flash['adLoginError'] : null ?></td>
</tr>
</table>
<br>
<input type="submit" value="ログイン">
</form>


<?php require '../footer.php'; ?>