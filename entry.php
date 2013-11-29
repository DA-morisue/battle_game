<?php
include './include/session.php';
include './include/db_access.php';


// 新規登録ボタンが押されたかを判定
if (isset($_POST["entry"])) {

	$id = $_POST["new_user_id"];
	$pass = $_POST["new_password"];

	//値が入力されているか確認する
	if ( $id == "" || $pass == "" || $_POST["re_password"] == "") {
		$error_message = "入力されていない値があります。";

	//入力されたパスワードが一致しているか確認する
	} elseif (!( $pass == $_POST["re_password"])) {
		$error_message = "入力されたパスワードが一致していません。";

	//入力されたidとパスワードが半角英数で構成されているか確認する
	} elseif (!(preg_match("/^([a-zA-Z0-9])+$/", $id) && preg_match("/^([a-zA-Z0-9])+$/", $pass))) {
		$error_message = "ID及びパスワードは半角英数のみ使用できます。";

	//入力されたパスワードが8文字以上～32文字以内であるか確認する
	} elseif (mb_strlen($pass) < 8 && mb_strlen($pass) > 32) {
		$error_message = "パスワードは8文字以上～256文字以内で設定してください。";

	//入力された情報に問題なければ登録処理を行う
	} else {
		//DBからユーザー情報を取得
		$link = db_access();
		$result = mysql_query('SELECT * FROM user WHERE user_id = "'.$id.'";');

		if (!$result) {
			die('クエリーが失敗しました。'.mysql_error());
		}

		$user = mysql_fetch_assoc($result);
		// ユーザー名を確認
		// すでに登録されているユーザー名の場合はエラーを出す
		if ($id == $user["user_id"]) {
			$error_message = "そのIDはすでに使われています。<br>違うIDに変更してください。<br>";
		}else{
		// 未登録のユーザー名の場合は新規登録する。

			//パスワードの暗号化処理
			include './include/encrypt.php';
			$pass = encryptin($pass);

			//日付の取得
			$datetime = date("Y-m-d H:i:s");

			//データの登録
			$entry = mysql_query('INSERT INTO battle_game.user( user_id , password , time ) VALUES ( "'.$id.'","'.$pass.'","'.$datetime.'" );');

			if (!$entry) {
				die('クエリーが失敗しました。'.mysql_error());
			}
		}

		//DB切断処理
		db_close($link);
	}
}

include './include/header.php';

echo('<hr>');

// 入力情報にエラーがある場合はエラーメッセージ表示
if (isset($error_message)) {
	print '<p id="error">'.$error_message.'</p>';
}

if (isset($entry)) {
	//登録成功時はこちらを表示
	echo(
	$_POST["new_user_id"].'さんの新規登録に成功しました。<br>こちらからログインしてください。<br>
	<hr>
	<form action="login.php" method="POST">
	▼ID<br><input type="text" name="user_id" value="" ><br>
	▼パスワード<br><input type="password" name="password" value="" ><br>
	<input type="submit" name="login" value="ログイン" >
	</form>

	<hr>
	<a href="./entry.php">新規登録はこちら</a>
	<hr>

	<a href="./login.php">ログインページ</a><br>
	<a href="./logout.php">ログアウトページ</a><br>
	<a href="./mypage.php">リザルトページ</a><br>');
}else{
	//初アクセスor登録失敗時はこちらを表示
	echo ('
	■IDとパスワードを入力してください。<br>
	半角英数のみを使用することができます。<br>
	パスワードは8文字以上で設定してください。<br>
	<br>
	<form action="entry.php" method="POST">
	▼ID<br><input type="text" name="new_user_id" value=""><br>
	▼パスワード<br><input type="password" name="new_password" value=""><br>
	▼再パスワード<br><input type="password" name="re_password" value=""><br>
	<input type="submit" name="entry" value="新規登録する" />
	</form>

	<hr>

	<a href="./login.php">ログインページ</a><br>
	<a href="./logout.php">ログアウトページ</a><br>
	<a href="./mypage.php">リザルトページ</a><br>');
}


include './include/footer.php';

?>

