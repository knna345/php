<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');


//表示したいエラーメッセージ==========

//スレッドタイトル----------
if(empty($_POST['title'])){
    $_SESSION['flash']['title'] = 'スレッドタイトルは必須入力です';
}
if (mb_strlen($_POST['title'] , "UTF-8") > 100) {
    $_SESSION['flash']['titleLength'] = "スレッドタイトルは１００文字以内で入力してください";
}
$_SESSION['original']['title'] = htmlspecialchars($_POST['title']);  //入力があった場合、一旦セッションに保存


//コメント----------
if(empty($_POST['content'])){
    $_SESSION['flash']['content'] = 'コメントは必須入力です';
}
if (mb_strlen($_POST['content'] , "UTF-8") > 500) {
    $_SESSION['flash']['contentLength'] = "コメントは５００文字以内で入力してください";
}
if(! empty($_POST['content'])){
    $_SESSION['original']['contentHTML'] = htmlspecialchars($_POST['content']);
}


$_SESSION['original']['content'] = htmlspecialchars($_POST['content']);  //入力があった場合、一旦セッションに保存



//エラーメッセージが出る場合フォームに返す----------
if(! empty($_SESSION['flash'])){
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/thread_regist.php');
}



// 二重送信防止用トークンの発行==========
$token = uniqid('', true);;

//トークンをセッション変数にセット
$_SESSION['token'] = $token;

?>

<div class="thread_confirm main">

<h1>スレッド作成確認画面</h1>

<table>
<tr>
  <td>スレッドタイトル　　</td>
  <td><?php echo htmlspecialchars($_POST['title'])?></td>
</tr>
<tr>
  <td valign="top">コメント　　　　　　</td>
  <td><p><?php echo nl2br($_SESSION['original']['content']); ?></p></td>
</tr>
</table>

<form action ="thread_end.php" method="post">
    <input type="hidden" name="token" value="<?php echo $token;?>">
    <input type="submit" value="スレッドを作成する">
</form>


<br>
<button type="button" onclick="location.href='thread_regist.php'">前に戻る</button>

</div>

<?php require './footer.php'; ?>