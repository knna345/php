<?php require './header.php'; ?>
<?php
session_start();

//DB接続
$pdo = new PDO("mysql:host=localhost;dbname=php;charset=utf8;", 'staff', 'password');


//ログインしている場合
$member = isset($_SESSION['member']) ? $_SESSION['member'] : [];


//入力があった場合、一旦セッションに保存
$_SESSION['original']['keyword'] = $_POST['keyword']; 

//オリジナルに上書き
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);

?>


<!--　ヘッダー　-->

<header>
    <div class="header-left">
        
    </div>
    <nav class="nav">
        <ul class="menu-group">
            <?php if (isset($_SESSION['member'])) : ?>
            <li class="btn login-item"><a href="./thread_regist.php">新規スレッド作成</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>


<!--　メイン　スレッド一覧　-->

<div class="thread main">

<form action="" method="post">
    <input type="text" name="keyword" size="48" value="<?php echo isset($original['keyword']) ? $original['keyword'] : null;?>">
    　　<input type="submit" value="スレッド検索">
</form>

    <div class="thread_data">

    <table>
    <tr><td></td><td></td><td></td></tr>
    <?php 
    if (! empty($original['keyword'])){
        //入力された場合----------
        $sql = $pdo -> prepare('select * from threads where title like ? or content like ? order by created_at DESC');
        $sql -> execute(['%'.$original['keyword'].'%', '%'.$original['keyword'].'%']);
        foreach ($sql as $row) {
            echo '<tr>';
            echo '<td>ID:', $row['id'], '　</td>';
            $br = '<br>';
            echo '<td>', htmlspecialchars($row['title']), '　</td>';
            $formattedDate = date("Y-m-d H:i", strtotime($row['created_at']));
            echo '<td>', $formattedDate, '</td>';
            echo '</tr>';
        }
    }else{
        //空欄の場合----------
        foreach ($pdo -> query('select * from threads order by created_at DESC') as $row){
            echo '<tr>';
            echo '<td>ID:', $row['id'], '　</td>';
            $br = '<br>';
            echo '<td>', htmlspecialchars($row['title']), '　</td>';
            $formattedDate = date("Y-m-d H:i", strtotime($row['created_at']));
            echo '<td>', $formattedDate, '</td>';
            echo '</tr>';
        }
    }

    ?>

    </table>

    </div>

<br>
<button type="button" onclick="location.href='top.php'">トップに戻る</button>

</div>

<?php require './footer.php'; ?>