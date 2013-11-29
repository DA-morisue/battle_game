<?php
include './include/session.php';
include './include/db_access.php';

// ログインボタンが押されたかを判定
// 初めてのアクセスでは認証は行わずエラーメッセージは表示しないように
if (isset($_POST["login"])) {


	$id = htmlspecialchars($_POST['user_id'],ENT_QUOTES);
	$pass = htmlspecialchars($_POST['password'],ENT_QUOTES);

	//--------------------------------------
	//入力確認
	//--------------------------------------
	if (empty($_POST["password"])) {
		$error_message = 'パスワードを入力してください。';
	}

	if (empty($_POST["user_id"])) {
		$error_message = 'IDを入力してください。';
	}

	if (!isset($error_message)) {
		//DBからユーザー情報を取得
		$link = db_access();$result = mysql_query('SELECT * FROM user WHERE user_id = "'.$_POST["user_id"].'";');

		if (!$result) {
			die('クエリーが失敗しました。'.mysql_error());
		}

		$user = mysql_fetch_assoc($result);


		// ユーザー名とパスワードが一致した場合はログイン処理を行う
		include './include/encrypt.php';
		if ($id == $user["user_id"] && pass_check( $pass , $user["password"] )) {

			// ログインが成功した証をセッションに保存
			$_SESSION["user_id"] = $id;

			// リザルトページにリダイレクトする
			$login_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/battle_game/mypage.php");
			header("Location: {$login_url}");
		}else{
			$error_message = "IDもしくはパスワードが間違っています。";
		}
	}
}





include './include/header.php';

echo('<hr>');

// セッション結果の表示テスト
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

echo('<hr>');


// パスワード入力にエラーがある場合はエラーメッセージ表示
if (isset($error_message)) {
	print '<p id="error">'.$error_message.'</p>';
}
?>


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
<a href="./mypage.php">リザルトページ</a><br>




<?php
include './include/footer.php';
?>
