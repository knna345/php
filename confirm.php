<?php require '../header.php'; ?>
<?php
session_start();

//表示したいエラーメッセージ

//氏名（姓）
if(empty($_POST['name_sei'])){
    $_SESSION['flash']['name_sei'] = '氏名（姓）は必須入力です';
}
if (strlen($_POST['name_sei']) > 20) {
    $_SESSION['flash']['name_seiLength'] = "氏名（姓）は２０文字以内で入力してください";
}
if (! empty($_POST['name_sei']) && ! preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $_POST['name_sei'])){
    $_SESSION['flash']['name_seiCheck'] = "氏名（姓）は漢字ひらがなカタカナで入力してください" ;
}
$_SESSION['original']['name_sei'] = $_POST['name_sei'];  //入力があった場合、一旦セッションに保存

//氏名（名）
if(empty($_POST['name_mei'])){
    $_SESSION['flash']['name_mei'] = '氏名（名）は必須入力です';
}
if (strlen($_POST['name_mei']) > 20) {
    $_SESSION['flash']['name_meiLength'] = "氏名（名）は２０文字以内で入力してください";
}
if (! empty($_POST['name_mei']) && ! preg_match("/[ぁ-ん]+|[ァ-ヴー]+|[一-龠]/u", $_POST['name_mei'])){
    $_SESSION['flash']['name_meiCheck'] = "氏名（名）は漢字ひらがなカタカナで入力してください" ;
}
$_SESSION['original']['name_mei'] = $_POST['name_mei'];  //入力があった場合、一旦セッションに保存

//性別
if(empty($_POST['gender'])){
    $_SESSION['flash']['gender'] = '性別は必須入力です';
}
$_SESSION['original']['gender'] = $_POST['gender'];  //入力があった場合、一旦セッションに保存

//都道府県
if($_POST['pref_name'] == "0"){
    $_SESSION['flash']['pref_name'] = '住所（都道府県）は必須入力です';
}
$_SESSION['original']['pref_name'] = $_POST['pref_name'];  //入力があった場合、一旦セッションに保存


//住所（それ以降の住所）
if (strlen($_POST['address']) > 100) {
    $_SESSION['flash']['addressLength'] = "住所（それ以降の住所）は１００文字以内で入力してください";
}
$_SESSION['original']['address'] = $_POST['address'];  //入力があった場合、一旦セッションに保存

//パスワード
if(empty($_POST['password'])){
    $_SESSION['flash']['password'] = 'パスワードは必須入力です';
}
if (! empty($_POST['password']) && (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 8)) {
    $_SESSION['flash']['passwordLength'] = "パスワードは８字以上２０文字以内で入力してください";
}
if (! empty($_POST['password']) && ! preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])){
    $_SESSION['flash']['passwordCheck'] = "パスワードは半角英数字で入力してください" ;
}
$_SESSION['original']['password'] = $_POST['password'];  //入力があった場合、一旦セッションに保存

//パスワード確認
if(empty($_POST['passwordConfirm'])){
    $_SESSION['flash']['passwordConfirm'] = 'パスワード確認は必須入力です';
}
if (! empty($_POST['passwordConfirm']) && (strlen($_POST['passwordConfirm']) > 20 || strlen($_POST['passwordConfirm']) < 8)) {
    $_SESSION['flash']['passwordConfirmLength'] = "パスワード確認は８字以上２０文字以内で入力してください";
}
if (! empty($_POST['passwordConfirm']) && ! preg_match('/^[a-zA-Z0-9]+$/', $_POST['passwordConfirm'])){
    $_SESSION['flash']['passwordConfirmCheck'] = "パスワード確認は半角英数字で入力してください" ;
}
if (! ($_POST['password'] === $_POST['passwordConfirm'])){
    $_SESSION['flash']['passwordConfirmMatch'] = "パスワードが一致しません" ;
}
$_SESSION['original']['passwordConfirm'] = $_POST['passwordConfirm'];  //入力があった場合、一旦セッションに保存

//メールアドレス
if(empty($_POST['email'])){
    $_SESSION['flash']['email'] = 'メールアドレスは必須入力です';
}
if (strlen($_POST['email']) > 200) {
    $_SESSION['flash']['emailLength'] = "メールアドレスは２００文字以内で入力してください";
}
if (! empty($_POST['email']) && ! preg_match('/^[a-z0-9._+^~-]+@[a-z0-9.-]+$/i', $_POST['email'])){
    $_SESSION['flash']['emailCheck'] = "メールアドレスを入力してください" ;
}
$_SESSION['original']['email'] = $_POST['email'];  //入力があった場合、一旦セッションに保存


//空欄の時入力フォームに返す
//if(empty($_POST['name_sei']) || empty($_POST['name_mei']) || empty($_POST['gender']) || empty($_POST['pref_name']) || empty($_POST['password']) || empty($_POST['passwordConfirm']) || empty($_POST['email'])){
  //  header('Location:http://localhost/html_lesson/PHP/member_regist.php');
//}

//エラーメッセージが出る場合フォームに返す
if(! empty($_SESSION['flash'])){
    header('Location:http://localhost/html_lesson/PHP/member_regist.php');
}

switch ($_POST['gender']){
    case 'male':
        $gender = '男性';
        break;

    case 'female':
        $gender = '女性';
        break;
}

switch ($_POST['pref_name']){
    case '0':
    $pref = '';
    break;

    case '1':
    $pref = '北海道';
    break;
    
    case '2':
    $pref = '青森県';
    break;
    
    case '3':
    $pref = '岩手県';
    break;
    
    case '4':
    $pref = '宮城県';
    break;
    
    case '5':
    $pref = '秋田県';
    break;
    
    case '6':
    $pref = '山形県';
    break;
    
    case '7':
    $pref = '福島県';
    break;
    
    case '8':
    $pref = '茨城県';
    break;
    
    case '9':
    $pref = '栃木県';
    break;
    
    case '10':
    $pref = '群馬県';
    break;
    
    case '11':
    $pref = '埼玉県';
    break;
    
    case '12':
    $pref = '千葉県';
    break;
    
    case '13':
    $pref = '東京都';
    break;
    
    case '14':
    $pref = '神奈川県';
    break;
    
    case '15':
    $pref = '新潟県';
    break;
    
    case '16':
    $pref = '富山県';
    break;
    
    case '17':
    $pref = '石川県';
    break;
    
    case '18':
    $pref = '福井県';
    break;
    
    case '19':
    $pref = '山梨県';
    break;
    
    case '20':
    $pref = '長野県';
    break;
    
    case '21':
    $pref = '岐阜県';
    break;
    
    case '22':
    $pref = '静岡県';
    break;
    
    case '23':
    $pref = '愛知県';
    break;
    
    case '24':
    $pref = '三重県';
    break;
    
    case '25':
    $pref = '滋賀県';
    break;
    
    case '26':
    $pref = '京都府';
    break;
    
    case '27':
    $pref = '大阪府';
    break;
    
    case '28':
    $pref = '兵庫県';
    break;
    
    case '29':
    $pref = '奈良県';
    break;
    
    case '30':
    $pref = '和歌山県';
    break;
    
    case '31':
    $pref = '鳥取県';
    break;
    
    case '32':
    $pref = '島根県';
    break;
    
    case '33':
    $pref = '岡山県';
    break;
    
    case '34':
    $pref = '広島県';
    break;
    
    case '35':
    $pref = '山口県';
    break;
    
    case '36':
    $pref = '徳島県';
    break;
    
    case '37':
    $pref = '香川県';
    break;
    
    case '38':
    $pref = '愛媛県';
    break;
    
    case '39':
    $pref = '高知県';
    break;
    
    case '40':
    $pref = '福岡県';
    break;
    
    case '41':
    $pref = '佐賀県';
    break;
    
    case '42':
    $pref = '長崎県';
    break;
    
    case '43':
    $pref = '熊本県';
    break;
    
    case '44':
    $pref = '大分県';
    break;
    
    case '45':
    $pref = '宮崎県';
    break;
    
    case '46':
    $pref = '鹿児島県';
    break;
    
    case '47':
    $pref = '沖縄県';
    break;
}

?>

<h1>会員情報確認画面</h1>
<p>氏名　　　　　　<?php echo $_POST['name_sei']?><?php echo $_POST['name_mei']?></p>
<p>性別　　　　　　<?php echo $gender ?></p>
<p>住所　　　　　　<?php echo $pref ?><?php echo $_POST['address']?></p>
<p>パスワード　　　セキュリティのため非表示</p>
<p>メールアドレス　<?php echo $_POST['email']?></p>

<form action ="member_end.php" method="post">
    <input type="submit" value="登録完了">
</form>

<button type="button" onclick="location.href='member_regist.php'">前に戻る</button>


<?php require '../footer.php'; ?>