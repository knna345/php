<?php require './header.php'; ?>
<?php
session_start();


if(isset($_SESSION['member'])){
    unset($_SESSION['member']);
    unset($_SESSION['original']);
    unset($member);
    unset($original);
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/top.php');
}

?>


<?php require './footer.php'; ?>
