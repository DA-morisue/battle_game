<?php
include 'header.php';
include 'db_access.php';

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow,noarchive">
<title>バトル</title>
	<link href="./morisueke.css" type="text/css" rel="stylesheet">
</head>
<body>



<!-- ヘッダー -->

<table>
<tr><td>
</td>
<td align="right">
<script type="text/javascript"><!--
	  document.write (document.lastModified + "更新")
	  //--></SCRIPT>
</td>
</table>

<hr>

■ログアウトページ<br>
<?php
    print('セッション変数の確認をします。<br>');
    if (!isset($_SESSION["user_name"])){
        print('セッション変数user_nameは登録されていません。<br>');
    }else{
        print($_SESSION["user_name"].'<br>');
    }

    print('セッションIDの確認をします。<br>');
    if (!isset($_COOKIE["PHPSESSID"])){
        print('セッションは登録されていません。<br>');
    }else{
        print($_COOKIE["PHPSESSID"].'<br>');
    }
?>

<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./result.php">リザルトページ</a><br>




<!-- フッター -->
<p style='clear:both'>
<hr>

<table>
<tr><td>
</td>
<td align="right">
<script type="text/javascript"><!--
	  document.write (document.lastModified + "更新")
	  //--></SCRIPT>
</td>
</table>

</body>
</html>
