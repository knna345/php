<?php require '../header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8mb4;", 'staff', 'password');


unset($_SESSION['original']);
unset($_SESSION['flash']);

//表示したいエラーメッセージ

//氏名（姓）----------
if(empty($_POST['name_sei'])){
    $_SESSION['flash']['name_sei'] = '※氏名（姓）は必須入力です';
}
if (mb_strlen($_POST['name_sei'] , "UTF-8") > 20) {
    $_SESSION['flash']['name_seiLength'] = "※氏名（姓）は２０文字以内で入力してください";
}
//if (! empty($_POST['name_sei']) && ! preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $_POST['name_sei'])){
   // $_SESSION['flash']['name_seiCheck'] = "氏名（姓）は漢字ひらがなカタカナで入力してください" ;
//}
$_SESSION['original']['name_sei'] = htmlspecialchars($_POST['name_sei']);  //入力があった場合、一旦セッションに保存


//氏名（名）----------
if(empty($_POST['name_mei'])){
    $_SESSION['flash']['name_mei'] = '※氏名（名）は必須入力です';
}
if (mb_strlen($_POST['name_mei'] , "UTF-8") > 20) {
    $_SESSION['flash']['name_meiLength'] = "※氏名（名）は２０文字以内で入力してください";
}
//if (! empty($_POST['name_mei']) && ! preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $_POST['name_mei'])){
    //$_SESSION['flash']['name_meiCheck'] = "氏名（名）は漢字ひらがなカタカナで入力してください" ;
//}
$_SESSION['original']['name_mei'] = htmlspecialchars($_POST['name_mei']);  //入力があった場合、一旦セッションに保存


//性別----------
if(empty($_POST['gender'])){
    $_SESSION['flash']['gender'] = '※性別は必須入力です';
}
//開発ツールで男性・女性以外の値をvalue値に入れるとエラー　したのswitch文で実装
//if (! $_POST['gender'] == 'male' || ! $_POST['gender'] == 'female'){
   // $_SESSION['flash']['genderNot'] = "男性または女性を選択してください"
//}
$_SESSION['original']['gender'] = $_POST['gender'];  //入力があった場合、一旦セッションに保存


//都道府県----------
if($_POST['pref_name'] == "0"){
    $_SESSION['flash']['pref_name'] = '※住所（都道府県）は必須入力です';
}
$validPrefectures = [
    '0', '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県',
    '茨城県', '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県',
    '新潟県', '富山県', '石川県', '福井県', '山梨県', '長野県', '岐阜県',
    '静岡県', '愛知県', '三重県', '滋賀県', '京都府', '大阪府', '兵庫県',
    '奈良県', '和歌山県', '鳥取県', '島根県', '岡山県', '広島県', '山口県',
    '徳島県', '香川県', '愛媛県', '高知県', '福岡県', '佐賀県', '長崎県',
    '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県'];
if (!in_array($_POST['pref_name'], $validPrefectures)) {
    $_SESSION['flash']['pref_nameNot'] = "※選択肢の都道府県から選択してください";
}
$_SESSION['original']['pref_name'] = $_POST['pref_name'];  //入力があった場合、一旦セッションに保存

//住所（それ以降の住所）----------
if (mb_strlen($_POST['address'] , "UTF-8") > 100) {
    $_SESSION['flash']['addressLength'] = "※住所（それ以降の住所）は１００文字以内で入力してください";
}
$_SESSION['original']['address'] = htmlspecialchars($_POST['address']);  //入力があった場合、一旦セッションに保存


//パスワード----------
//if(empty($_POST['password'])){
    //$_SESSION['flash']['password'] = '※パスワードは必須入力です';
//}
if (! empty($_POST['password']) && (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8)) {
    $_SESSION['flash']['passwordLength'] = "※パスワードは８字以上２０文字以内で入力してください";
}
if (! empty($_POST['password']) && ! preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])){
    $_SESSION['flash']['passwordCheck'] = "※パスワードは半角英数字で入力してください" ;
}
$_SESSION['original']['password'] = $_POST['password'];  //入力があった場合、一旦セッションに保存


//パスワード確認----------
if((! empty($_POST['password'])) AND empty($_POST['passwordConfirm'])){
    $_SESSION['flash']['passwordConfirm'] = '※パスワード確認は必須入力です';
}
if (! empty($_POST['passwordConfirm']) && (strlen($_POST['passwordConfirm']) > 20 || strlen($_POST['passwordConfirm']) < 8)) {
    $_SESSION['flash']['passwordConfirmLength'] = "※パスワード確認は８字以上２０文字以内で入力してください";
}
if (! empty($_POST['passwordConfirm']) && ! preg_match('/^[a-zA-Z0-9]+$/', $_POST['passwordConfirm'])){
    $_SESSION['flash']['passwordConfirmCheck'] = "※パスワード確認は半角英数字で入力してください" ;
}
if (! ($_POST['password'] === $_POST['passwordConfirm'])){
    $_SESSION['flash']['passwordConfirmMatch'] = "※パスワードが一致しません" ;
}
$_SESSION['original']['passwordConfirm'] = $_POST['passwordConfirm'];  //入力があった場合、一旦セッションに保存


//メールアドレス----------
if(empty($_POST['email'])){
    $_SESSION['flash']['email'] = '※メールアドレスは必須入力です';
}
if (strlen($_POST['email']) > 200) {
    $_SESSION['flash']['emailLength'] = "※メールアドレスは２００文字以内で入力してください";
}
if (! empty($_POST['email']) && ! preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $_POST['email'])){
    $_SESSION['flash']['emailCheck'] = "※メールアドレスを入力してください" ;
}
//メールがDBに既に登録があった場合エラーの表示
$sql = $pdo -> prepare('SELECT id from members where email= :email');
$sql->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
$sql -> execute();
$existingUser = $sql->fetch(PDO::FETCH_ASSOC);


if($existingUser && $existingUser['id'] !==  $_SESSION['edit']['id'] ){
    $_SESSION['flash']['emailDup'] = "※登録済みのメールアドレスは使用できません" ;
}

$_SESSION['original']['email'] = htmlspecialchars($_POST['email']);  //入力があった場合、一旦セッションに保存



//空欄の時入力フォームに返す
//if(empty($_POST['name_sei']) || empty($_POST['name_mei']) || empty($_POST['gender']) || empty($_POST['pref_name']) || empty($_POST['password']) || empty($_POST['passwordConfirm']) || empty($_POST['email'])){
  //  header('Location:http://localhost/html_lesson/PHP/member_regist.php');
//}

//エラーメッセージが出る場合フォームに返す----------
$url = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member_edit.php?id=' . $_SESSION['edit']['id'];
if(! empty($_SESSION['flash'])){
    $url = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member_edit.php?id=' . $_SESSION['edit']['id'];
    header('Location:' .$url);
}

// 二重送信防止用トークンの発行
$token = uniqid('', true);;

//トークンをセッション変数にセット
$_SESSION['token'] = $token;

//表示用データ置き換え（性別）
switch ($_POST['gender']){
    case '1':
        $gender = '男性';
        $_SESSION['original']['genderName'] = $gender;
        break;

    case '2':
        $gender = '女性';
        $_SESSION['original']['genderName'] = $gender;
        break;
    default:
        $_SESSION['flash']['genderNot'] = "※選択肢の性別から選択してください";
        break;
}


?>

<!---------------------------------------　ヘッダー　------------------------------------------>
<header>
        <div class="header-left">
            会員編集
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn login-item"><a href="./top.php">トップへ戻る</a></li>
            </ul>
        </nav>
</header>

<!---------------------------------------　登録確認画面　------------------------------------------>

<div class="member_confirm-wrapper main" style=" margin-top: 50px; ">

<table>
<tr>
    <td>ID</td>
    <td><?php echo $_SESSION['edit']['id'] ?></td></tr>
<tr>
    <td>氏名</td>
    <td><?php echo htmlspecialchars($_POST['name_sei'])?>　<?php echo htmlspecialchars($_POST['name_mei'])?></td></tr>
<tr>
    <td>性別</td>
    <td><?php echo $gender ?></td></tr>
<tr>
    <td>住所</td>
    <td><?php echo $_POST['pref_name'] ?><?php echo htmlspecialchars($_POST['address'])?></td></tr>
<tr>
    <td>パスワード</td>
    <td>セキュリティのため非表示</td></tr>
<tr>
    <td>メールアドレス　</td>
    <td><?php echo htmlspecialchars($_POST['email'])?></td></tr>
</table>

<form action ="member_edit_end.php" method="post">
    <input type="hidden" name="token" value="<?php echo $token;?>">
    <input type="submit" value="登録完了">
</form>
<br>

<button type="button" onclick="location.href='<?php echo $url; ?>' ">前に戻る</button>

</div>

<?php require '../footer.php'; ?>