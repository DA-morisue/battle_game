<?php
include 'header.php';
include 'db_access.php';


// 新規登録ボタンが押されたかを判定
if (isset($_POST["entry"])) {

	//値が入力されているか確認する
	if ( $_POST["new_user_name"] == "" || $_POST["new_password"] == "" || $_POST["re_password"] == "" ) {
		$error_message = "入力されていない値があります。<br>";
	} elseif (!( $_POST["new_password"] == $_POST["re_password"])) {
		//入力されたパスワードが一致しているか確認する
		$error_message = "入力されたパスワードが一致していません。<br>";
	} else {
		//入力された情報に問題なければ登録処理を行う
		//DBからユーザー情報を取得
		$link = db_access();
		$result = mysql_query('SELECT * FROM user WHERE user_name = "'.$_POST["new_user_name"].'";');
	
		if (!$result) {
			die('クエリーが失敗しました。'.mysql_error());
		}
	
		$user = mysql_fetch_assoc($result);
	
		// ユーザー名を確認
		// すでに登録されているユーザー名の場合はエラーを出す
		if ($_POST["new_user_name"] == $user["user_name"]) {
			$error_message = "そのユーザー名はすでに使われています。<br>違うユーザー名に変更してください。<br>";
		}else{
		// 未登録のユーザー名の場合は新規登録する。
			$datetime = date("Y-m-d H:i:s");
			$entry = mysql_query('INSERT INTO battle_game.user( user_name , password , time ) VALUES ( "'.$_POST["new_user_name"].'","'.$_POST["new_password"].'","'.$datetime.'" );');

			if (!$entry) {
				die('クエリーが失敗しました。'.mysql_error());
			}
		}

		//DB切断処理
		db_close($link);
	}
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
//     print('セッション変数の確認をします。<br>');
//     if (!isset($_SESSION["user_name"])){
//         print('セッション変数user_nameは登録されていません。<br>');
//     }else{
//         print($_SESSION["user_name"].'<br>');
//     }

//     print('セッションIDの確認をします。<br>');
//     if (!isset($_COOKIE["PHPSESSID"])){
//         print('セッションは登録されていません。<br>');
//     }else{
//         print($_COOKIE["PHPSESSID"].'<br>');
//     }
?>

<hr>





<?php
if ($error_message) {
print '<font color="red">'.$error_message.'</font>';
}

if ($entry) {
	echo($_POST["new_user_name"].'さんの新規登録に成功しました。<br><a href="./login.php">こちら</a>からログインしてください。');
}else{echo ('
	■ユーザー名とパスワードを入力してください。
	<form action="entry.php" method="POST">
	ユーザ名：<input type="text" name="new_user_name" value="" /><br />
	パスワード：<input type="password" name="new_password" value="" /><br />
	再パスワード：<input type="password" name="re_password" value="" /><br />
	<input type="submit" name="entry" value="新規登録する" />
	</form>
	
	<hr>
	
	<a href="./login.php">ログインページ</a><br>
	<a href="./logout.php">ログアウトページ</a><br>
	<a href="./result.php">リザルトページ</a><br>');
}

?>


</body>
</html>
