<?php
//----------------------------------------
//
// ユーザー情報取得クラス
//
//----------------------------------------

class user {
	public $user_data;
	

	function __construct($user_id) {
		// DBからユーザー情報を取得
		$db_link = db_access();
		
		$sth = $db_link->prepare('SELECT * FROM user WHERE id = :user_id');
		$sth->bindValue(':user_id' , $user_id , PDO::PARAM_INT);
		$sth->execute();
			
		$this->user_data = $sth->fetch();

		// DB切断処理
		db_close($db_link);
	}
}



?>