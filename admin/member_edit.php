<?php require '../header.php'; ?>
<?php

session_start();



//ログインしている場合

$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];

// セッションのflashメッセージをクリア
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);


// 過去のPOSTデータをクリア
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);

//-------------------------------
//会員IDの取得
$getId = isset($_GET['id']) ? $_GET['id'] : [];

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

?>

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


<!---------------------------------------　会員登録画面　------------------------------------------>

<div class="form-wrapper main"  style=" margin-top: 50px; ">

<form action="member_edit_confirm.php" method="post">

<table>
<tr>
    <td>ID</td>
    <td><?php echo $getId; ?></td>
</tr>
<tr>
  <td>氏名</td>
  <td>姓　<input type="text" name="name_sei" value="<?php echo isset($original['name_sei']) ? $original['name_sei'] : $_SESSION['edit']['name_sei']; ?>">
    　名　<input type="text" name="name_mei" value="<?php echo isset($original['name_mei']) ? $original['name_mei'] : $_SESSION['edit']['name_mei'];?>"></td>
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
  <td><input type="radio" name="gender" value="1" <?php 
        if (isset($original['gender']) && $original['gender'] == "1"){
            echo 'checked';
        }elseif(!(isset($original['gender'])) && $_SESSION['edit']['gender'] == "1"){
            echo 'checked';
        } ?>>男性
      <input type="radio" name="gender" value="2" <?php 
        if (isset($original['gender']) && $original['gender'] == "2"){
            echo 'checked';
        }elseif(!(isset($original['gender'])) && $_SESSION['edit']['gender'] == "2"){
            echo 'checked';
        } ?>>女性</td>
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
    <option value="北海道" <?php if (isset($original['pref_name']) && $original['pref_name'] == "北海道"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "北海道"){echo 'selected';} ?>>北海道</option>
    <option value="青森県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "青森県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "青森県"){echo 'selected';} ?>>青森県</option>
    <option value="岩手県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "岩手県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "岩手県"){echo 'selected';} ?>>岩手県</option>
    <option value="宮城県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "宮城県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "宮城県"){echo 'selected';} ?>>宮城県</option>
    <option value="秋田県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "秋田県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "秋田県"){echo 'selected';} ?>>秋田県</option>
    <option value="山形県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "山形県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "山形県"){echo 'selected';} ?>>山形県</option>
    <option value="福島県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "福島県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "福島県"){echo 'selected';} ?>>福島県</option>
    <option value="茨城県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "茨城県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "茨城県"){echo 'selected';} ?>>茨城県</option>
    <option value="栃木県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "栃木県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "栃木県"){echo 'selected';} ?>>栃木県</option>
    <option value="群馬県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "群馬県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "群馬県"){echo 'selected';} ?>>群馬県</option>
    <option value="埼玉県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "埼玉県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "埼玉県"){echo 'selected';} ?>>埼玉県</option>
    <option value="千葉県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "千葉県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "千葉県"){echo 'selected';} ?>>千葉県</option>
    <option value="東京都" <?php if (isset($original['pref_name']) && $original['pref_name'] == "東京都"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "東京都"){echo 'selected';} ?>>東京都</option>
    <option value="神奈川県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "神奈川県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "神奈川県"){echo 'selected';} ?>>神奈川県</option>
    <option value="新潟県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "新潟県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "新潟県"){echo 'selected';} ?>>新潟県</option>
    <option value="富山県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "富山県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "富山県"){echo 'selected';} ?>>富山県</option>
    <option value="石川県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "石川県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "石川県"){echo 'selected';} ?>>石川県</option>
    <option value="福井県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "福井県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "福井県"){echo 'selected';} ?>>福井県</option>
    <option value="山梨県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "山梨県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "山梨県"){echo 'selected';} ?>>山梨県</option>
    <option value="長野県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "長野県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "長野県"){echo 'selected';} ?>>長野県</option>
    <option value="岐阜県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "岐阜県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "岐阜県"){echo 'selected';} ?>>岐阜県</option>
    <option value="静岡県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "静岡県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "静岡県"){echo 'selected';} ?>>静岡県</option>
    <option value="愛知県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "愛知県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "愛知県"){echo 'selected';} ?>>愛知県</option>
    <option value="三重県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "三重県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "三重県"){echo 'selected';} ?>>三重県</option>
    <option value="滋賀県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "滋賀県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "滋賀県"){echo 'selected';} ?>>滋賀県</option>
    <option value="京都府" <?php if (isset($original['pref_name']) && $original['pref_name'] == "京都府"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "京都府"){echo 'selected';} ?>>京都府</option>
    <option value="大阪府" <?php if (isset($original['pref_name']) && $original['pref_name'] == "大阪府"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "大阪府"){echo 'selected';} ?>>大阪府</option>
    <option value="兵庫県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "兵庫県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "兵庫県"){echo 'selected';} ?>>兵庫県</option>
    <option value="奈良県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "奈良県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "奈良県"){echo 'selected';} ?>>奈良県</option>
    <option value="和歌山県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "和歌山県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "和歌山県"){echo 'selected';} ?>>和歌山県</option>
    <option value="鳥取県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "鳥取県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "鳥取県"){echo 'selected';} ?>>鳥取県</option>
    <option value="島根県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "島根県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "島根県"){echo 'selected';} ?>>島根県</option>
    <option value="岡山県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "岡山県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "岡山県"){echo 'selected';} ?>>岡山県</option>
    <option value="広島県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "広島県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "広島県"){echo 'selected';} ?>>広島県</option>
    <option value="山口県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "山口県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "山口県"){echo 'selected';} ?>>山口県</option>
    <option value="徳島県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "徳島県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "徳島県"){echo 'selected';} ?>>徳島県</option>
    <option value="香川県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "香川県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "香川県"){echo 'selected';} ?>>香川県</option>
    <option value="愛媛県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "愛媛県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "愛媛県"){echo 'selected';} ?>>愛媛県</option>
    <option value="高知県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "高知県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "高知県"){echo 'selected';} ?>>高知県</option>
    <option value="福岡県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "福岡県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "福岡県"){echo 'selected';} ?>>福岡県</option>
    <option value="佐賀県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "佐賀県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "佐賀県"){echo 'selected';} ?>>佐賀県</option>
    <option value="長崎県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "長崎県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "長崎県"){echo 'selected';} ?>>長崎県</option>
    <option value="熊本県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "熊本県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "熊本県"){echo 'selected';} ?>>熊本県</option>
    <option value="大分県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "大分県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "大分県"){echo 'selected';} ?>>大分県</option>
    <option value="宮崎県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "宮崎県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "宮崎県"){echo 'selected';} ?>>宮崎県</option>
    <option value="鹿児島県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "鹿児島県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "鹿児島県"){echo 'selected';} ?>>鹿児島県</option>
    <option value="沖縄県" <?php if (isset($original['pref_name']) && $original['pref_name'] == "沖縄県"){ echo 'selected';}elseif(!(isset($original['pref_name'])) && $_SESSION['edit']['pref_name'] == "沖縄県"){echo 'selected';} ?>>沖縄県</option>
    <?php echo isset($original['pref_name']) ? $original['pref_name'] : null;?>
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
  <td>それ以降の住所<input type="text" name="address" value="<?php echo isset($original['address']) ? $original['address'] : $_SESSION['edit']['address'];?>"></td>
</tr>
<tr>
  <td ></td>
  <td><?php echo isset($flash['addressLength']) ? $flash['addressLength'] : null ?></td>
</tr>
<tr>
  <td>パスワード</td>
  <td><input type="password" name="password" value="<?php echo isset($original['password']) ? $original['password'] : null;?>"></td>
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
  <td><input type="password" name="passwordConfirm" value="<?php echo isset($original['passwordConfirm']) ? $original['passwordConfirm'] : null;?>"></td>
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
  <td><input type="text" name="email" value="<?php echo isset($original['email']) ? $original['email'] : $_SESSION['edit']['email'];?>"></td>
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