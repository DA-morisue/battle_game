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




// DBアクセステスト<br>

<?php

//DB接続処理
function db_access() {

	//mysql接続
	$dsn = "mysql:dbname=test;host=localhost;";
	$user = "morisue";
	$password = "7815659";
	
	try{
		$db_link = new PDO($dsn, $user, $password);
		$db_link->query('SET NAMES utf8');
		print('Connection OK!<br>');
	}catch (PDOException $e){
		print('Connection failed:'.$e->getMessage());
		die();
	}
	
	return $db_link;
}

//DB切断処理
function db_close($db_link) {
	$db_link = null;
}


$pdo = db_access();

// SELECTテスト
$stmt = $pdo->query("SELECT * FROM test ORDER BY id");
while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
 $id = $row["id"];
 $user_name = $row["user_name"];
 $user_type = $row["user_type"];
 $time = $row["time"];
echo<<<EOF

$id:$user_name [$user_type] $time <br>

EOF;
}

// INSERTテスト
$stmt = $pdo -> prepare("INSERT INTO test ( user_name, user_type) VALUES ( :name, :type)");

$name = "david";

$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':type', 1, PDO::PARAM_INT);


$stmt->execute();

db_close($pdo);



?>

<br>
// 暗号化テスト<br>
<?php
$record = array();

for ( $i = 0; $i < 10; $i++ ){


//-----処理時間計測開始-----------------------

$time_start = microtime(true);

//---------------------------------------------

	$pass = "password";
//	echo $pass."<br>";

	$password = hash("sha256",$pass);
//	echo $password."<br>";


// 参考url:http://wawatete.ddo.jp/exec/program/php/php_password

	$saltLength = 32;

	$password = "任意のパスワード";
	//「Salt」の作成
	$salt = substr(md5(uniqid(rand(), true)), 0, $saltLength);
	// 任意のパスワードに「Salt」を付加
	$encryptedpassword = $salt.$password;
	//「Iteration Count」回数分の暗号化実行
	$iterationCount = 1000;
	for( $count=0 ; $count < $iterationCount ; $count++ )
	{
		$encryptedpassword =  hash("sha256",$encryptedpassword);
	}
	//暗号化されたパスワードに「Salt」を付加した状態で、ファイル等に保存
//	print $salt.$encryptedpassword."<br>"."<br>";



//-----処理時間計測終了-----------------------

	$time_end = microtime(true);
	$time = $time_end - $time_start;

//	echo "実行時間:{$time}秒<br><br>";

//---------------------------------------------

	array_push($record, $time);
}

$average = 0;
for ( $i = 0 ; $i < count($record); $i++){
	echo "実行時間[".$i."]：".$record[$i]."秒<br>";
	$average = $average + $record[$i];
}

echo "<br>実行時間[平均]：".($average/10)."秒<br>";


?>


</body>
</html>