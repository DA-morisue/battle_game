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
<hr>
名前：<br>
HP：<br>
スタミナ：<br>
<hr>
攻撃力：<br>
属性：<br>
<hr>
防御力：<br>
火耐性：<br>
水耐性：<br>
雷耐性：<br>
氷耐性：<br>
龍耐性：<br>
<hr>
武器：<br>
頭防具：<br>
胴防具：<br>
腕防具：<br>
腰防具：<br>
脚防具：<br>
<hr>
発動スキル1：<br>
発動スキル2：<br>
発動スキル3：<br>
発動スキル4：<br>
発動スキル5：<br>

<hr>

<form action="logout.php" method="POST">
<input type="submit" name="logout" value="ログアウト" />
</form>

<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./mypage.php">リザルトページ</a><br>


<?php
include './include/footer.php';
?>