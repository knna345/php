<?php require '../header.php'; ?>
<?php
session_start();


if(isset($_SESSION['admin'])){
    unset($_SESSION['admin']);
    unset($_SESSION['original']);
    unset($admin);
    unset($original);
    header('Location:https://ik1-219-79869.vs.sakura.ne.jp/php/admin/login.php');
}

?>


<?php require '../footer.php'; ?>