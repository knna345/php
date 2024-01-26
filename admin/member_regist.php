<?php require '../header.php'; ?>
<?php

session_start();


//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');

//ログインしている場合

$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];

// セッションのflashメッセージをクリア
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);


// 過去のPOSTデータをクリア
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);
?>

<!---------------------------------------　ヘッダー　------------------------------------------>
<header>
        <div class="header-left">
            会員登録
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn"><a href="./member.php">一覧へ戻る</a></li>
            </ul>
        </nav>
</header>


<!---------------------------------------　会員登録画面　------------------------------------------>

<div class="form-wrapper main"  style=" margin-top: 50px; ">

<form action="member_regist_confirm.php" method="post">

<table>
<tr>
    <td>ID</td>
    <td>登録後に自動採番</td>
</tr>
<tr>
  <td>氏名</td>
  <td>姓　<input type="text" name="name_sei" value="<?php echo isset($original['name_sei']) ? $original['name_sei'] : null;?>">
    　名　<input type="text" name="name_mei" value="<?php echo isset($original['name_mei']) ? $original['name_mei'] : null;?>"></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['name_sei']) ? $flash['name_sei'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['name_seiLength']) ? $flash['name_seiLength'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['name_seiCheck']) ? $flash['name_seiCheck'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['name_mei']) ? $flash['name_mei'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['name_meiLength']) ? $flash['name_meiLength'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['name_meiCheck']) ? $flash['name_meiCheck'] : null ?></td>
</tr>
<tr>
  <td>性別</td>
  <td><input type="radio" name="gender" value="1" <?php if (isset($original['gender']) && $original['gender'] == "1") echo 'checked'; ?>>男性
      <input type="radio" name="gender" value="2" <?php if (isset($original['gender']) && $original['gender'] == "2") echo 'checked'; ?>>女性</td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['gender']) ? $flash['gender'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['genderNot']) ? $flash['genderNot'] : null ?></td>
</tr>
<tr>
  <td>住所</td>
  <td>都道府県　　　<select name="pref_name">
    <option value="0">選択してください</option>
    <option value="1" <?php if (isset($original['pref_name']) && $original['pref_name'] == "1") echo 'selected'; ?>>北海道</option>
    <option value="2" <?php if (isset($original['pref_name']) && $original['pref_name'] == "2") echo 'selected'; ?>>青森県</option>
    <option value="3" <?php if (isset($original['pref_name']) && $original['pref_name'] == "3") echo 'selected'; ?>>岩手県</option>
    <option value="4" <?php if (isset($original['pref_name']) && $original['pref_name'] == "4") echo 'selected'; ?>>宮城県</option>
    <option value="5" <?php if (isset($original['pref_name']) && $original['pref_name'] == "5") echo 'selected'; ?>>秋田県</option>
    <option value="6" <?php if (isset($original['pref_name']) && $original['pref_name'] == "6") echo 'selected'; ?>>山形県</option>
    <option value="7" <?php if (isset($original['pref_name']) && $original['pref_name'] == "7") echo 'selected'; ?>>福島県</option>
    <option value="8" <?php if (isset($original['pref_name']) && $original['pref_name'] == "8") echo 'selected'; ?>>茨城県</option>
    <option value="9" <?php if (isset($original['pref_name']) && $original['pref_name'] == "9") echo 'selected'; ?>>栃木県</option>
    <option value="10" <?php if (isset($original['pref_name']) && $original['pref_name'] == "10") echo 'selected'; ?>>群馬県</option>
    <option value="11" <?php if (isset($original['pref_name']) && $original['pref_name'] == "11") echo 'selected'; ?>>埼玉県</option>
    <option value="12" <?php if (isset($original['pref_name']) && $original['pref_name'] == "12") echo 'selected'; ?>>千葉県</option>
    <option value="13" <?php if (isset($original['pref_name']) && $original['pref_name'] == "13") echo 'selected'; ?>>東京都</option>
    <option value="14" <?php if (isset($original['pref_name']) && $original['pref_name'] == "14") echo 'selected'; ?>>神奈川県</option>
    <option value="15" <?php if (isset($original['pref_name']) && $original['pref_name'] == "15") echo 'selected'; ?>>新潟県</option>
    <option value="16" <?php if (isset($original['pref_name']) && $original['pref_name'] == "16") echo 'selected'; ?>>富山県</option>
    <option value="17" <?php if (isset($original['pref_name']) && $original['pref_name'] == "17") echo 'selected'; ?>>石川県</option>
    <option value="18" <?php if (isset($original['pref_name']) && $original['pref_name'] == "18") echo 'selected'; ?>>福井県</option>
    <option value="19" <?php if (isset($original['pref_name']) && $original['pref_name'] == "19") echo 'selected'; ?>>山梨県</option>
    <option value="20" <?php if (isset($original['pref_name']) && $original['pref_name'] == "20") echo 'selected'; ?>>長野県</option>
    <option value="21" <?php if (isset($original['pref_name']) && $original['pref_name'] == "21") echo 'selected'; ?>>岐阜県</option>
    <option value="22" <?php if (isset($original['pref_name']) && $original['pref_name'] == "22") echo 'selected'; ?>>静岡県</option>
    <option value="23" <?php if (isset($original['pref_name']) && $original['pref_name'] == "23") echo 'selected'; ?>>愛知県</option>
    <option value="24" <?php if (isset($original['pref_name']) && $original['pref_name'] == "24") echo 'selected'; ?>>三重県</option>
    <option value="25" <?php if (isset($original['pref_name']) && $original['pref_name'] == "25") echo 'selected'; ?>>滋賀県</option>
    <option value="26" <?php if (isset($original['pref_name']) && $original['pref_name'] == "26") echo 'selected'; ?>>京都府</option>
    <option value="27" <?php if (isset($original['pref_name']) && $original['pref_name'] == "27") echo 'selected'; ?>>大阪府</option>
    <option value="28" <?php if (isset($original['pref_name']) && $original['pref_name'] == "28") echo 'selected'; ?>>兵庫県</option>
    <option value="29" <?php if (isset($original['pref_name']) && $original['pref_name'] == "29") echo 'selected'; ?>>奈良県</option>
    <option value="30" <?php if (isset($original['pref_name']) && $original['pref_name'] == "30") echo 'selected'; ?>>和歌山県</option>
    <option value="31" <?php if (isset($original['pref_name']) && $original['pref_name'] == "31") echo 'selected'; ?>>鳥取県</option>
    <option value="32" <?php if (isset($original['pref_name']) && $original['pref_name'] == "32") echo 'selected'; ?>>島根県</option>
    <option value="33" <?php if (isset($original['pref_name']) && $original['pref_name'] == "33") echo 'selected'; ?>>岡山県</option>
    <option value="34" <?php if (isset($original['pref_name']) && $original['pref_name'] == "34") echo 'selected'; ?>>広島県</option>
    <option value="35" <?php if (isset($original['pref_name']) && $original['pref_name'] == "35") echo 'selected'; ?>>山口県</option>
    <option value="36" <?php if (isset($original['pref_name']) && $original['pref_name'] == "36") echo 'selected'; ?>>徳島県</option>
    <option value="37" <?php if (isset($original['pref_name']) && $original['pref_name'] == "37") echo 'selected'; ?>>香川県</option>
    <option value="38" <?php if (isset($original['pref_name']) && $original['pref_name'] == "38") echo 'selected'; ?>>愛媛県</option>
    <option value="39" <?php if (isset($original['pref_name']) && $original['pref_name'] == "39") echo 'selected'; ?>>高知県</option>
    <option value="40" <?php if (isset($original['pref_name']) && $original['pref_name'] == "40") echo 'selected'; ?>>福岡県</option>
    <option value="41" <?php if (isset($original['pref_name']) && $original['pref_name'] == "41") echo 'selected'; ?>>佐賀県</option>
    <option value="42" <?php if (isset($original['pref_name']) && $original['pref_name'] == "42") echo 'selected'; ?>>長崎県</option>
    <option value="43" <?php if (isset($original['pref_name']) && $original['pref_name'] == "43") echo 'selected'; ?>>熊本県</option>
    <option value="44" <?php if (isset($original['pref_name']) && $original['pref_name'] == "44") echo 'selected'; ?>>大分県</option>
    <option value="45" <?php if (isset($original['pref_name']) && $original['pref_name'] == "45") echo 'selected'; ?>>宮崎県</option>
    <option value="46" <?php if (isset($original['pref_name']) && $original['pref_name'] == "46") echo 'selected'; ?>>鹿児島県</option>
    <option value="47" <?php if (isset($original['pref_name']) && $original['pref_name'] == "47") echo 'selected'; ?>>沖縄県</option>
    <?php echo isset($original['pref']) ? $original['pref'] : null;?>
  </select></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['pref_name']) ? $flash['pref_name'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['pref_nameNot']) ? $flash['pref_nameNot'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td>それ以降の住所<input type="text" name="address" value="<?php echo isset($original['address']) ? $original['address'] : null;?>"></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['addressLength']) ? $flash['addressLength'] : null ?></td>
</tr>
<tr>
  <td>パスワード</td>
  <td><input type="password" name="password" value=""></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['password']) ? $flash['password'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['passwordLength']) ? $flash['passwordLength'] : null ?> </td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['passwordCheck']) ? $flash['passwordCheck'] : null ?></td>
</tr>
<tr>
  <td>パスワード確認</td>
  <td><input type="password" name="passwordConfirm" value=""></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['passwordConfirm']) ? $flash['passwordConfirm'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['passwordConfirmLength']) ? $flash['passwordConfirmLength'] : null ?> </td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['passwordConfirmCheck']) ? $flash['passwordConfirmCheck'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['passwordConfirmMatch']) ? $flash['passwordConfirmMatch'] : null ?></td>
</tr>
<tr>
  <td>メールアドレス</td>
  <td><input type="text" name="email" value="<?php echo isset($original['email']) ? $original['email'] : null;?>"></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['email']) ? $flash['email'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['emailLength']) ? $flash['emailLength'] : null ?> </td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['emailCheck']) ? $flash['emailCheck'] : null ?></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['emailDup']) ? $flash['emailDup'] : null ?></td>
</tr>
</table>

<input type="submit" value="確認画面へ">
</form>

</div>

<?php require '../footer.php'; ?>