<?php
session_start();
session_regenerate_id(true); // sessionハイジャック防止

// ログイン状態を確認してのリダイレクト処理
if (!isset($_SESSION["user_name"])) {
	// ログインしていない場合
	switch ($_SERVER["SCRIPT_NAME"]) {
		// ログインページ、ログアウトページ、エントリーページなら何もしない
		case '/battle_game/login.php':
		case '/battle_game/logout.php':
		case '/battle_game/entry.php':
			break;

		default:
			// 変数に値がセットされていない場合は不正な処理と判断し、ログイン画面へリダイレクトさせる
			$redirect_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/battle_game/login.php");
			header("Location: {$redirect_url}");
			exit;
	}
} else {
	// ログアウトがPOSTされていればログアウト処理を行って、ログアウトページにリダイレクトする。
	if (isset($_POST["logout"])) {
		//セッション変数は上書きして初期化
		$_SESSION = array();
			
		//cookieのセッションIDを破棄
		if (isset($_COOKIE["PHPSESSID"])) {
			setcookie("PHPSESSID", '', time() - 1800, '/');
		}
		//セッションを破棄
		session_destroy();

		// ログアウトページにリダイレクト
		$redirect_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/battle_game/logout.php");
		header("Location: {$redirect_url}");
		exit;
	}

	switch ($_SERVER["SCRIPT_NAME"]) {
		//ログイン状態でログインページ、ログアウトページ、エントリーページにアクセスした場合
		case '/battle_game/login.php':
		case '/battle_game/logout.php':
		case '/battle_game/entry.php':
			//変数に値がセットされている(ログイン)済みの場合はリザルトページにリダイレクトする。
			$redirect_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/battle_game/result.php");
			header("Location: {$redirect_url}");
			exit;
		
		// ログイン状態でゲーム内のページはそのままアクセスする。
		default:
			$user_name = $_SESSION["user_name"];
			print $user_name."さん　ログイン成功";
			break;
	}
}

?>