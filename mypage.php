<?php
require_once './include/session.php';

include './include/header.php';


class user {
	public $user;

	function __construct($user_id) {
		// DBからユーザー情報を取得
		$db_link = db_access();
		
		$sth = $db_link->prepare('SELECT * FROM user WHERE id = :user_id');
		$sth->bindValue(':user_id' , $user_id , PDO::PARAM_INT);
		$sth->execute();
			
		$this->user = $sth->fetch();

		// DB切断処理
		db_close($db_link);
	}
}

class chara{
	public $chara;
	
	function __construct($chara_id) {
		// DBからユーザー情報を取得
		$link = db_access();
		$sth = $db_link->prepare('SELECT * FROM charactor WHERE id = :chara_id');
		$sth->bindValue(':id' , $chara_id , PDO::PARAM_INT);
		$sth->execute();
		
		$this->chara = mysql_fetch_assoc($result);

		// DB切断処理
		db_close($link);
	}
}

$user = new user($user_id);
echo "ID:".$user_id."<br>";
dump_html($user);

?>
<hr>
名前：<?php echo $user->user["user_name"]?><br>
HP：<br>
スタミナ：<br>
<hr>
攻撃力：<br>
属性：<br>
<hr>
防御力：<br>
火耐性：<br>
水耐性：<br>
雷耐性：<br>
氷耐性：<br>
龍耐性：<br>
<hr>
武器：<br>
頭防具：<br>
胴防具：<br>
腕防具：<br>
腰防具：<br>
脚防具：<br>
<hr>
発動スキル1：<br>
発動スキル2：<br>
発動スキル3：<br>
発動スキル4：<br>
発動スキル5：<br>

<hr>

<form action="logout.php" method="POST">
<input type="submit" name="logout" value="ログアウト" />
</form>

<hr>

<a href="./login.php">ログインページ</a><br>
<a href="./logout.php">ログアウトページ</a><br>
<a href="./mypage.php">リザルトページ</a><br>


<?php
include './include/footer.php';
?>