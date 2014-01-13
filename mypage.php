<?php
require_once './include/session.php';

include './include/header.php';


//　ユーザー情報
$user = new user($user_id);
echo "ID:".$user_id."<br>";
echo "ユーザー名:".$user->user_data['user_name']."<br>";

//　キャラ情報
$chara = new chara($user->user_data['chara_01']);

// ポストされた装備品を切り替え
$wear_type = array(head , body , arm , waist , leg );
foreach ($wear_type as $value) {
	if ($_POST[$value] !== null ) {
		$chara->equip_wear($value, $_POST[$value]);
	};
}

?>
<hr>
名前：<?php echo $chara->chara_data['chara_name']?><br>
HP：<br>
スタミナ：<br>
<hr>
攻撃力：<br>
属性：<br>
<hr>
防御力：<?php echo $chara->chara_data['def']?><br>
火耐性：<?php echo $chara->chara_data['def_fire']?><br>
水耐性：<?php echo $chara->chara_data['def_water']?><br>
雷耐性：<?php echo $chara->chara_data['def_thunder']?><br>
氷耐性：<?php echo $chara->chara_data['def_ice']?><br>
龍耐性：<?php echo $chara->chara_data['def_dragon']?><br>
<hr>
武器：<br>
頭防具：<?php echo $chara->head_data['name']?><br>
胴防具：<?php echo $chara->body_data['name']?><br>
腕防具：<?php echo $chara->arm_data['name']?><br>
腰防具：<?php echo $chara->waist_data['name']?><br>
脚防具：<?php echo $chara->leg_data['name']?><br>
<hr>
発動スキル1：<br>
発動スキル2：<br>
発動スキル3：<br>
発動スキル4：<br>
発動スキル5：<br>

<hr>
<?php 
dump_html($chara->skill_category_list);
?>
<hr>
<?php
if (count($chara->active_skill_list) < 1) {
	echo '発動スキル無し';
}else{
	for ($i = 0; $i < count($chara->active_skill_list); $i++) {
		echo $chara->active_skill_list[$i][name].'<br>';
	}
}
?>
<hr>
■防具変更
<form action="mypage.php" method="POST" id="equip_wear">
	<p>
	
	<?php
	// 防具選択UI生成
	$wear_type = array(head , body , arm , waist , leg );
	foreach ($wear_type as $value) {
		echo '<label for="'.$value.'">'.$value.'を選択：</label>';
		echo '<select id="'.$value.'" name="'.$value.'" form="equip_wear">';
		
		$db_link = db_access();
		$sql = 'SELECT * FROM '.$value.'_data';
		$sth = $db_link->prepare($sql);
		$sth->execute();
		
		while ($row = $sth->fetch()) {
			if ($row["id"] == $chara->{$value."_data"}['id']) {
				echo '<option selected value='.$row["id"].'>'.$row["id"].':'.$row['name'].'[装備中]</option>';
			}else{
				echo '<option value='.$row["id"].'>'.$row["id"].':'.$row['name'].'</option>';
			}
		}
		db_close($db_link);
		
		echo '</select><br>';
	}
	?>
	</p>
	<input type="submit" name="equip_wear" value="防具変更" >
</form>
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