<?php
require_once './include/session.php';
include './include/header.php';

if ($_POST['db_update_wear']) {
	require_once './tool/csv2db.php';
	echo '防具データベースを更新しました';
}
?>
<a >

<form action="management.php" method="POST">
<input type="hidden" name="db_update_wear" value="true" ><br>
<input type="submit" name="db_update_wear" value="防具DB更新" >
</form>
<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./mypage.php">リザルトページ</a><br>

<?php
include './include/footer.php';
?>
