<?php require '../header.php'; ?>
<?php

session_start();


//ログインしている場合

$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];


//----------------------------------------------------
//入力があった場合、一旦セッションに保存
$_SESSION['search']['id'] = $_POST['id']; 
$_SESSION['search']['gender1'] = $_POST['gender1']; 
$_SESSION['search']['gender2'] = $_POST['gender2']; 
$_SESSION['search']['pref_name'] = $_POST['pref_name']; 
$_SESSION['search']['freeword'] = $_POST['freeword']; 

//検索ワードに上書き
$search = isset($_SESSION['search']) ? $_SESSION['search'] : [];

unset($_SESSION['search']);

//----------------------------------------------------
///DBから~~~メンバー情報~~~受け取り
// 1ページあたりのコメント数
$membersPerPage = 10;

// 現在のページ番号を取得（デフォルトは1）
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
unset($_GET['page']);
$_SESSION['searchCurrentPage'] = $currentPage;

// コメントの開始位置
$offset = ($currentPage - 1) * $membersPerPage;

?>

<!---------------------------------------　ヘッダー　------------------------------------------>
<header>
        <div class="header-left">
            会員一覧
        </div>
        <nav class="nav">
            <ul class="menu-group">
                <li class="btn login-item"><a href="./top.php">トップへ戻る</a></li>
            </ul>
        </nav>
</header>

<!----------------------------------------　メイン　検索フォーム　------------------------------------------>
<div class = "main" style=" margin-top: 50px; ">
    <form action="" method="post">
    <table border="1" width="500" style="border-collapse: collapse; margin: auto;" class="search">
        <tr>
            <th>ID</th>
            <td><input type="text" name="id" value="<?php echo isset($search['id']) ? $search['id'] : null;?>"></td>
        </tr>
        <tr>
            <th>性別</th>
            <td><input type="checkbox" name="gender1" value="1" <?php if (isset($search['gender1']) && $search['gender1'] == "1") echo 'checked'; ?>>男性
                <input type="checkbox" name="gender2" value="2" <?php if (isset($search['gender2']) && $search['gender2'] == "2") echo 'checked'; ?>>女性</td>
        </tr>
        <tr>
            <th>都道府県</th>
            <td><select name="pref_name">
                <option value=""></option>
                <option value="北海道" <?php if (isset($search['pref_name']) && $search['pref_name'] == "北海道") echo 'selected'; ?>>北海道</option>
                <option value="青森県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "青森県") echo 'selected'; ?>>青森県</option>
                <option value="岩手県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "岩手県") echo 'selected'; ?>>岩手県</option>
                <option value="宮城県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "宮城県") echo 'selected'; ?>>宮城県</option>
                <option value="秋田県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "秋田県") echo 'selected'; ?>>秋田県</option>
                <option value="山形県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "山形県") echo 'selected'; ?>>山形県</option>
                <option value="福島県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "福島県") echo 'selected'; ?>>福島県</option>
                <option value="茨城県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "茨城県") echo 'selected'; ?>>茨城県</option>
                <option value="栃木県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "栃木県") echo 'selected'; ?>>栃木県</option>
                <option value="群馬県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "群馬県") echo 'selected'; ?>>群馬県</option>
                <option value="埼玉県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "埼玉県") echo 'selected'; ?>>埼玉県</option>
                <option value="千葉県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "千葉県") echo 'selected'; ?>>千葉県</option>
                <option value="東京都" <?php if (isset($search['pref_name']) && $search['pref_name'] == "東京都") echo 'selected'; ?>>東京都</option>
                <option value="神奈川県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "神奈川県") echo 'selected'; ?>>神奈川県</option>
                <option value="新潟県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "新潟県") echo 'selected'; ?>>新潟県</option>
                <option value="富山県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "富山県") echo 'selected'; ?>>富山県</option>
                <option value="石川県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "石川県") echo 'selected'; ?>>石川県</option>
                <option value="福井県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "福井県") echo 'selected'; ?>>福井県</option>
                <option value="山梨県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "山梨県") echo 'selected'; ?>>山梨県</option>
                <option value="長野県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "長野県") echo 'selected'; ?>>長野県</option>
                <option value="岐阜県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "岐阜県") echo 'selected'; ?>>岐阜県</option>
                <option value="静岡県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "静岡県") echo 'selected'; ?>>静岡県</option>
                <option value="愛知県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "愛知県") echo 'selected'; ?>>愛知県</option>
                <option value="三重県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "三重県") echo 'selected'; ?>>三重県</option>
                <option value="滋賀県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "滋賀県") echo 'selected'; ?>>滋賀県</option>
                <option value="京都府" <?php if (isset($search['pref_name']) && $search['pref_name'] == "京都府") echo 'selected'; ?>>京都府</option>
                <option value="大阪府" <?php if (isset($search['pref_name']) && $search['pref_name'] == "大阪府") echo 'selected'; ?>>大阪府</option>
                <option value="兵庫県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "兵庫県") echo 'selected'; ?>>兵庫県</option>
                <option value="奈良県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "奈良県") echo 'selected'; ?>>奈良県</option>
                <option value="和歌山県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "和歌山県") echo 'selected'; ?>>和歌山県</option>
                <option value="鳥取県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "鳥取県") echo 'selected'; ?>>鳥取県</option>
                <option value="島根県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "島根県") echo 'selected'; ?>>島根県</option>
                <option value="岡山県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "岡山県") echo 'selected'; ?>>岡山県</option>
                <option value="広島県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "広島県") echo 'selected'; ?>>広島県</option>
                <option value="山口県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "山口県") echo 'selected'; ?>>山口県</option>
                <option value="徳島県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "徳島県") echo 'selected'; ?>>徳島県</option>
                <option value="香川県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "香川県") echo 'selected'; ?>>香川県</option>
                <option value="愛媛県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "愛媛県") echo 'selected'; ?>>愛媛県</option>
                <option value="高知県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "高知県") echo 'selected'; ?>>高知県</option>
                <option value="福岡県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "福岡県") echo 'selected'; ?>>福岡県</option>
                <option value="佐賀県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "佐賀県") echo 'selected'; ?>>佐賀県</option>
                <option value="長崎県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "長崎県") echo 'selected'; ?>>長崎県</option>
                <option value="熊本県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "熊本県") echo 'selected'; ?>>熊本県</option>
                <option value="大分県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "大分県") echo 'selected'; ?>>大分県</option>
                <option value="宮崎県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "宮崎県") echo 'selected'; ?>>宮崎県</option>
                <option value="鹿児島県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "鹿児島県") echo 'selected'; ?>>鹿児島県</option>
                <option value="沖縄県" <?php if (isset($search['pref_name']) && $search['pref_name'] == "沖縄県") echo 'selected'; ?>>沖縄県</option>
                <?php echo isset($search['pref_name']) ? $search['pref_name'] : null;?>
        </tr>
        <tr>
            <th>フリーワード</th>
            <td><input type="text" name="freeword" value="<?php echo isset($search['freeword']) ? $search['freeword'] : null;?>"></td>
        </tr>
    </table>
    <br>
    <div style="text-align : center ; "><input type="submit" value="検索する"></div>
    </form>
</div>

<!----------------------------------------　メイン　検索結果　------------------------------------------>
<?php

?>

<div class = "main" style=" margin-top: 50px; ">
    <table border="1"  width="700" style="border-collapse: collapse; margin: auto;" class="resultSearch">
        <tr>
            <td>ID</td>
            <td>氏名</td>
            <td>性別</td>
            <td>住所</td>
            <td>登録日時</td>
        </tr>

            <?php
        
            //データベース接続、メンバー情報取得
            $sql = 'SELECT * FROM members WHERE 1';
            $params = [];
            //ID
            if (!empty($search['id'])) {
                $sql .= " AND id = :id";
                $params[':id'] = $search['id'];
            }
            //gender
            if ((!empty($search['gender1'])) && (!empty($search['gender2'])) ) { //男性・女性
                $sql .= " AND ( gender = :gender1 OR gender = :gender2 )" ;
                $params[':gender1'] = $search['gender1'];
                $params[':gender2'] = $search['gender2'];
            }elseif(!empty($search['gender1'])){ //男性
                $sql .= " AND gender = :gender1" ;
                $params[':gender1'] = $search['gender1'];
            }elseif(!empty($search['gender2'])) { //女性
                $sql .= " AND gender = :gender2";
                $params[':gender2'] = $search['gender2'];
            }
            //都道府県
            if (!empty($search['pref_name'])) {
                $sql .= " AND pref_name = :pref_name";
                $params[':pref_name'] = $search['pref_name'];
            }
            //フリーワード　名前（名・姓）・メール
            if (!empty($search['freeword'])) {
                $sql .= " AND (name_sei LIKE :freeword OR name_mei LIKE :freeword OR email LIKE :freeword)";
                $params[':freeword'] = '%' . $search['freeword'] . '%';
            }
            $sql .= " LIMIT :offset, 10";
            $params[':offset'] = $offset;

            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            

            foreach($stmt as $result){
                echo '<tr>';
                echo '<th>'. $result['id'].'</th>';
                echo '<th>'. $result['name_sei']. "　" . $result['name_mei']. '</th>';
                if($result['gender'] === 1){
                    $gender = "男性";
                }elseif($result['gender'] === 2){
                    $gender = "女性";
                };
                echo '<th>'. $gender.'</th>';
                echo '<th>'. $result['pref_name']. $result['address']. '</th>';
                echo '<th>'. $result['email'].'</th>';
                echo '</tr>';
            }
        
            ?>

    </table>

</div>



<?php require '../footer.php'; ?>