<?php
include 'header.php';
include 'db_access.php';

// ログインボタンが押されたかを判定
// 初めてのアクセスでは認証は行わずエラーメッセージは表示しないように
if (isset($_POST["login"])) {

	//DBからユーザー情報を取得
	$link = db_access();$result = mysql_query('SELECT * FROM user WHERE user_name = "'.$_POST["user_name"].'";');

	if (!$result) {
		die('クエリーが失敗しました。'.mysql_error());
	}

	$user = mysql_fetch_assoc($result);


	// ユーザー名とパスワードが一致した場合はログイン処理を行う
	if ($_POST["user_name"] == $user["user_name"] && $_POST["password"] == $user["password"]) {
		
		// ログインが成功した証をセッションに保存
		$_SESSION["user_name"] = $_POST["user_name"];
		
		// リザルトページにリダイレクトする
		$login_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/eclips/battle_game/result.php");
		header("Location: {$login_url}");
		exit;
	}
	$error_message = "ユーザ名もしくはパスワードが違っています。";
}
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

<hr>

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





<?php
if ($error_message) {
print '<font color="red">'.$error_message.'</font>';
}
?>
<form action="login.php" method="POST">
ユーザ名：<input type="text" name="user_name" value="" /><br />
パスワード：<input type="password" name="password" value="" /><br />
<input type="submit" name="login" value="ログイン" />
</form>

<hr>
<a href="./entry.php">新規登録はこちら</a>
<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./result.php">リザルトページ</a><br>


</body>
</html>
