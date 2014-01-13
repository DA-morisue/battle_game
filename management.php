<?php
require_once './include/session.php';
include './include/header.php';
require_once './tool/csv2db.php';

?>



<form action="./management.php" method="POST" accept-charset="UTF-8">
<input type="hidden" name="db_update_wear" value="umauma" ><br>
<input type="submit" value="防具DB更新" >
</form>

<form action="./management.php" method="POST" accept-charset="UTF-8">
<input type="hidden" name="db_update_skill" value="hoge" ><br>
<input type="submit" value="スキルDB更新" >
</form>

<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./mypage.php">リザルトページ</a><br>

<?php
include './include/footer.php';
?>
