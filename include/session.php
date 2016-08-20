<?php
session_start();

// sessionハイジャック防止
if(mt_rand(1, 30)==1) {	// 実行確率
	$sess_file = 'sess_'.session_id();
	$sess_dir_path = ini_get('session.save_path');
	$sess_file_path = $sess_dir_path. '/'. $sess_file;
	$timestamp = filemtime($sess_file_path);
	$span = 5*60;		// 経過時間
	if(($timestamp+$span) < time()) {
		// PHP Ver取得
		$iPHPVer = (int)sprintf('%.3s', str_replace('.', '', PHP_VERSION));
		if($iPHPVer>=510) {
			session_regenerate_id(true);
		}else {
			$sess_tmp = $_SESSION;
			session_destroy();
			session_id(createUniqueKey(25, true));
			session_start();
			$_SESSION = $sess_tmp;
		}// end if
	}// end if
}// end if

// DBアクセス処理
require_once './include/db_access.php';

// デバッグ用の関数
require_once './include/debug.php';

// クラスオートロード処理
function __autoload($class_name) {
	$file = './class/'.$class_name.'.php';
	if (is_readable($file)) {
		require_once $file;
	}
}

// ユーザーidの確認
if (isset($_SESSION["user_id"])) {
	$user_id = $_SESSION["user_id"];
}

// ログイン状態を確認してのリダイレクト処理
if (!isset($_SESSION["user_name"])) {
	// ログインしていない場合
	switch ($_SERVER["SCRIPT_NAME"]) {
		// ログインページ、ログアウトページ、エントリーページなら何もしない
		case '/battle_game/login.php':
		case '/battle_game/logout.php':
		case '/battle_game/entry.php':
		case '/battle_game/management.php':
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
			//変数に値がセットされている(ログイン)済みの場合はマイページにリダイレクトする。
			$redirect_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/battle_game/mypage.php");
			header("Location: {$redirect_url}");
			exit;

		// ログイン状態でゲーム内のページはそのままアクセスする。
		default:
			$user_name = $_SESSION["user_name"];
			break;
	}
}

?>