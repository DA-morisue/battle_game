<?php
//DB接続処理
function db_access() {
	//mysql接続
	$link = mysql_connect('localhost', 'morisue', '7815659');
	if (!$link) {
		die('接続失敗です。'.mysql_error());
	}

	//DB選択
	$db_selected = mysql_select_db('battle_game', $link);
	if (!$db_selected){
		die('データベース選択失敗です。'.mysql_error());
	}
	return $link;
	
	//文字コードをutf8に設定
	mysql_set_charset('utf8');
}


//DB切断処理
function db_close($link) {
	//mysql切断
	$close_flag = mysql_close($link);
	
	// DBの切断に成功したらメッセージ表示
// 	if ($close_flag){
// 		print('<p>DBの切断に成功しました。</p>');
// 	}
	
	
	// エラーメッセージを格納する変数を初期化
	$error_message = "";
}
?>