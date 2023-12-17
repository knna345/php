<?php require './header.php'; ?>

<?php session_start();

// セッションのflashメッセージをクリア
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);


// 過去のPOSTデータをクリア
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];

?>


<?php if (isset($_SESSION['member'])) : ?>
<div class="thread-wrapper main">

<h1>スレッド作成フォーム</h1>

<form action="thread_confirm.php" method="post">
<table>
<tr>
  <td>スレッドタイトル</td>
  <td><input type="text" name="title" size="48" value="<?php echo isset($original['title']) ? $original['title'] : null;?>"></td>
</tr>
<tr>
  <td></td>
  <td><?php echo isset($flash['title']) ? $flash['title'] : null ?></td>
</tr>
<tr>
  <td></td>
  <td><?php echo isset($flash['titleLength']) ? $flash['titleLength'] : null ?></td>
</tr>
<tr>
  <td valign="top">コメント</td>
  <td><textarea name="content" rows="10" cols="50" wrap=”hard”><?php echo isset($original['content']) ? $original['content'] : null;?></textarea></td>
</tr>
<tr>
  <td></td>
  <td><?php echo isset($flash['content']) ? $flash['content'] : null ?></td>
</tr>
<tr>
  <td></td>
  <td><?php echo isset($flash['contentLength']) ? $flash['contentLength'] : null ?></td>
</tr>
</table>

<input type="submit" value="確認画面へ">
</form>
<br>
<button type="button" onclick="location.href='thread.php'">一覧に戻る</button>

</div>
<?php endif; ?>


<?php require './footer.php'; ?>