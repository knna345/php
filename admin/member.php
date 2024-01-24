<?php require '../header.php'; ?>
<?php

session_start();


//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');

//ログインしている場合

$admin = isset($_SESSION['admin']) ? $_SESSION['admin'] : [];


//----------------------------------------------------
//入力があった場合、一旦セッションに保存
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['search']['id'] = $_POST['id']; 
    $_SESSION['search']['gender1'] = $_POST['gender1']; 
    $_SESSION['search']['gender2'] = $_POST['gender2']; 
    $_SESSION['search']['pref_name'] = $_POST['pref_name']; 
    $_SESSION['search']['freeword'] = $_POST['freeword']; 

    //検索ワードに上書き
    unset($search);
}
    $search = isset($_SESSION['search']) ? $_SESSION['search'] : [];




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


//昇順・降順
// ソートの初期値を設定
$sortField = isset($_SESSION['sortField']) ? $_SESSION['sortField'] : 'id';
$sortOrder = isset($_SESSION['sortOrder']) ? $_SESSION['sortOrder'] : 'DESC';

// ソートリンクがクリックされた場合の処理
if (isset($_GET['sortField'])) {
    $clickedField = $_GET['sortField'];

    // クリックされたフィールドが現在のソートフィールドと同じ場合、ソート順を切り替える
    if (($clickedField == $sortField) AND $sortOrder == 'ASC') {
            $sortOrder = 'DESC';
    } elseif (($clickedField == $sortField) AND $sortOrder == 'DESC') {
            $sortOrder = 'ASC';
    } else {
        // クリックされたフィールドが異なる場合、ソートフィールドと順序を更新する
        $sortField = $clickedField;
        $sortOrder = 'DESC';
    }

    // セッションにソート情報を保存
    $_SESSION['sortField'] = $sortField;
    $_SESSION['sortOrder'] = $sortOrder;
}
?>

<?php if (isset($_SESSION['admin'])) : //ログイン時 ?>
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
    <form action="https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php" method="post">
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
            <td><input type="text" name="freeword" value="<?php echo isset($search['freeword'] ) ? $search['freeword']  : null;?>"></td>
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
            <th>ID<a href="?sortField=id">
                <?php 
                if($sortField == 'id' AND $sortOrder === 'ASC'){
                    echo '▲';
                }elseif($sortField == 'id' AND $sortOrder === 'DESC'){
                    echo '▼';
                }else{
                    echo '▼';
                }?></a>
            </th>
            <th>氏名</th>
            <th>性別</th>
            <th>住所</th>
            <th>登録日時<a href="?sortField=created_at">
                <?php
                if($sortField == 'created_at' AND $sortOrder === 'ASC'){
                    echo '▲';
                }elseif($sortField == 'created_at' AND $sortOrder === 'DESC'){
                    echo '▼';
                }else{
                    echo '▼';
                }?></a>
            </th>
        </tr>

            <?php
            //-----------------------------------------------
            //データベース接続、メンバー情報取得、メンバー情報総数取得
            $sql = 'SELECT * FROM members WHERE 1 = 1';
            $sqlCount = 'SELECT count(*) AS total FROM members WHERE 1 = 1';

            //ID
            if (!empty($search['id'])) {
                $sql .= " AND id = :id";
                $sqlCount .= " AND id = :id";
            }
            //gender
            if ((!empty($search['gender1'])) && (!empty($search['gender2'])) ) { //男性・女性
                $sql .= " AND ( gender = :gender1 OR gender = :gender2 )" ;
                $sqlCount .= " AND ( gender = :gender1 OR gender = :gender2 )" ;
            }elseif(!empty($search['gender1'])){ //男性
                $sql .= " AND gender = :gender1" ;
                $sqlCount .= " AND gender = :gender1" ;
            }elseif(!empty($search['gender2'])) { //女性
                $sql .= " AND gender = :gender2";
                $sqlCount .= " AND gender = :gender2";
            }
            //都道府県
            if (!empty($search['pref_name'])) {
                $sql .= " AND pref_name = :pref_name";
                $sqlCount .= " AND pref_name = :pref_name";
            }
            //フリーワード　名前（名・姓）・メール
            if (!empty($search['freeword'])) {
                $sql .= " AND (name_sei LIKE :freeword OR name_mei LIKE :freeword OR email LIKE :freeword)";
                $sqlCount .= " AND (name_sei LIKE :freeword OR name_mei LIKE :freeword OR email LIKE :freeword)";
            }

            //sort
            $sql .= " ORDER BY $sortField $sortOrder";
            
            //offset
            $sql .= " LIMIT :offset, 10";

            
            //-----------------------------------------------
            //メンバー情報検索を取得,SQL文---------
            $stmt = $pdo->prepare($sql);

            //bindValue if文--------
            //ID
            if (!empty($search['id'])) {
                $stmt->bindValue(':id', $search['id'], PDO::PARAM_INT);
            }
            //gender
            if((!empty($search['gender1'])) && (!empty($search['gender2']))){
                $stmt->bindValue(':gender1', $search['gender1'], PDO::PARAM_INT);
                $stmt->bindValue(':gender2', $search['gender2'], PDO::PARAM_INT);
            }elseif(!empty($search['gender1'])){
                $stmt->bindValue(':gender1', $search['gender1'], PDO::PARAM_INT);
            }elseif(!empty($search['gender2'])) {
                $stmt->bindValue(':gender2', $search['gender2'], PDO::PARAM_INT);
            }
            //prefName
            if (!empty($search['pref_name'])) {
                $stmt->bindValue(':pref_name', $search['pref_name'], PDO::PARAM_STR);
            }
            //freeword
            if (!empty($search['freeword'])) {
                $stmt->bindValue(':freeword', '%'.$search['freeword'].'%', PDO::PARAM_STR);
            }

            //offset---これはいつでもいる
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            //PDO実行--------------
            $stmt->execute();


            //-----------------------------------------------
            //検索結果に基づくデータベースからの総出力数を取得,SQL文
            $sqlCountMembers = $pdo->prepare($sqlCount);

            //bindValue if文-------
            //ID
            if (!empty($search['id'])) {
                $sqlCountMembers->bindValue(':id', $search['id'], PDO::PARAM_INT);
            }
            //gender
            if((!empty($search['gender1'])) && (!empty($search['gender2']))){
                $sqlCountMembers->bindValue(':gender1', $search['gender1'], PDO::PARAM_INT);
                $sqlCountMembers->bindValue(':gender2', $search['gender2'], PDO::PARAM_INT);
            }elseif(!empty($search['gender1'])){
                $sqlCountMembers->bindValue(':gender1', $search['gender1'], PDO::PARAM_INT);
            }elseif(!empty($search['gender2'])) {
                $sqlCountMembers->bindValue(':gender2', $search['gender2'], PDO::PARAM_INT);
            }
            //prefName
            if (!empty($search['pref_name'])) {
                $sqlCountMembers->bindValue(':pref_name', $search['pref_name'], PDO::PARAM_STR);
            }
            //freeword
            if (!empty($search['freeword'])) {
                $sqlCountMembers->bindValue(':freeword', '%'.$search['freeword'].'%', PDO::PARAM_STR);
            }

            //PDO実行-------------
            $sqlCountMembers->execute();
            $result = $sqlCountMembers -> fetch(PDO::FETCH_ASSOC);
            $totalMembers = $result['total'];



            //-----------------------------------------------
            // 総ページ数を計算、「次へ」「前へ」
            $totalPages = ceil($totalMembers / $membersPerPage);


            //-----------------------------------------------
            //検索結果の出力
            foreach($stmt as $result){
                echo '<tr>';
                echo '<td>'. $result['id'].'</td>';
                echo '<td>'. $result['name_sei']. "　" . $result['name_mei']. '</td>';
                if($result['gender'] === "1"){
                    $gender = "男性";
                }elseif($result['gender'] === "2"){
                    $gender = "女性";
                };
                echo '<td>'. $gender.'</td>';
                echo '<td>'. $result['pref_name']. $result['address']. '</td>';
                echo '<td>'. $result['created_at'].'</td>';
                echo '</tr>';
            }
        
            ?>

    </table>

<!--　メイン　会員情報ページめくりリンク -->
<div style="display: table; width: 40%; margin: 0 auto; margin-bottom: 20px; margin-top: 30px;">

    <?php
    //前へ
    if ($currentPage > 1 ){
        $memberPrevPageLink = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php?page=' . $currentPage -1;
        echo '<div style="display: table-cell; text-align: left;"> <a href=', $memberPrevPageLink ,'>＜ 前へ</a></div>';
    }elseif($currentPage == 1){
        echo '<p style="display: table-cell; text-align: left; color:gray;">　 　　</p>';
    };

    //ページめくり　3ページ分
    $memberPrevPageLink = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php?page=' . $currentPage -1;
    $memberNextPageLink = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php?page=' . $currentPage +1;

    if($currentPage > 1){
    echo '<div style="display: table-cell; text-align: center; border: 1px solid #000;"><a href=', $memberPrevPageLink ,'>'. $currentPage -1 . '</a></div>';
    }
    echo '<p style="display: table-cell; text-align: center; background-color: darkgray; border: 1px solid #000;">'. $currentPage .'</p>';
    if($currentPage < $totalPages){
    echo '<div style="display: table-cell; text-align: center; border: 1px solid #000;"><a href=', $memberNextPageLink ,'>'. $currentPage +1 . '</a></div>';
    }

    //次へ
    if ($currentPage < $totalPages){
        $memberNextPageLink = 'https://ik1-219-79869.vs.sakura.ne.jp/php/admin/member.php?page=' . $currentPage +1;
        echo '<div style="display: table-cell; text-align: right;"><a href=', $memberNextPageLink, '>次へ ＞</a></div>';
    }elseif($currentPage > $totalPages || $currentPage == $totalPages){
        echo '<p style="display: table-cell; text-align: right; color:gray;">　 　　</p>';
    }
    ?>

</div>


</div>

<?php endif; ?>

<?php require '../footer.php'; ?>