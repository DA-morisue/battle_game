<?php
require_once './include/session.php';


// ログインボタンが押されたかを判定
// 初めてのアクセスでは認証は行わずエラーメッセージは表示しないように
if (isset($_POST["login"])) {


	$user_name = htmlspecialchars($_POST['user_name'],ENT_QUOTES);
	$pass = htmlspecialchars($_POST['password'],ENT_QUOTES);

	//--------------------------------------
	//入力確認
	//--------------------------------------
	if (empty($_POST["password"])) {
		$error_message = 'パスワードを入力してください。';
	}

	if (empty($_POST["user_name"])) {
		$error_message = 'IDを入力してください。';
	}

	if (!isset($error_message)) {
		//DBからユーザー情報を取得
		$db_link = db_access();

		$sth = $db_link->prepare('SELECT * FROM user WHERE user_name = :user_name');
		$sth->bindValue(':user_name' , $_POST["user_name"] , PDO::PARAM_STR);
		$sth->execute();
		
		//DB切断処理
		db_close($db_link);
		
		$user = $sth->fetch();

		// ユーザー名とパスワードが一致した場合はログイン処理を行う
		require_once './include/encrypt.php';
		if ($user_name == $user["user_name"] && pass_check( $pass , $user["password"] )) {

			// ログインが成功した証をセッションに保存
			$_SESSION["user_name"] = $user_name;


			//DBからユーザー情報を取得
			$db_link = db_access();
			
			$sth = $db_link->prepare('SELECT id FROM user WHERE user_name = :user_name');
			$sth->bindValue(':user_name' , $_POST["user_name"] , PDO::PARAM_STR);
			$sth->execute();
				
			$user = $sth->fetch();
			
			// ユーザーidをセッションに保存
			$_SESSION["user_id"] = $user["id"];

			//DB切断処理
			db_close($db_link);

			// マイページにリダイレクトする
			$login_url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . "/battle_game/mypage.php");
			header("Location: {$login_url}");
		}else{
			$error_message = "IDもしくはパスワードが間違っています。";				
		}
	}
}





include './include/header.php';

echo('<hr>');

dump_html($_POST);
dump_html($_POST["login"]);

echo('<hr>');


// セッション結果の表示テスト
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

    if ($_SESSION['db_update_wear']) {
    	echo '防具のデータベースを更新しました。';
    	$_SESSION['db_update_wear'] = false;
    }
echo('<hr>');


// パスワード入力にエラーがある場合はエラーメッセージ表示
if (isset($error_message)) {
	print '<p id="error">'.$error_message.'</p>';
}
?>


<form action="login.php" method="POST">
▼ID<br><input type="text" name="user_name" value="" ><br>
▼パスワード<br><input type="password" name="password" value="" ><br>
<input type="submit" name="login" value="ログイン" >
</form>

<hr>
<a href="./entry.php">新規登録はこちら</a>
<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./mypage.php">マイページ</a><br>
<a href="./management.php">管理ページ</a><br>

<hr>

<?php
include './include/footer.php';
?>
