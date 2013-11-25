<?php
include './include/session.php';
include './include/db_access.php';

include './include/header.php';

echo('<hr>');


echo('■ログイン後のページ。<br>');
print('セッション変数の確認をします。<br>');
if (!isset($_SESSION["user_id"])){
    print('セッション変数user_idは登録されていません。<br>');
}else{
    print($_SESSION["user_id"].'<br>');
}

print('セッションIDの確認をします。<br>');
if (!isset($_COOKIE["PHPSESSID"])){
    print('セッションは登録されていません。<br>');
}else{
    print($_COOKIE["PHPSESSID"].'<br>');
}
?>

<form action="logout.php" method="POST">
<input type="submit" name="logout" value="ログアウト" />
</form>

<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./result.php">リザルトページ</a><br>


<?php
include './include/footer.php';
?>