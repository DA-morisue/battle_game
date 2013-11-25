<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="robots" content="noindex,nofollow,noarchive">
<title>バトル</title>
	<link href="./morisueke.css" type="text/css" rel="stylesheet">
</head>
<body>

<!-- ヘッダー -->

<table width="100%">
<tr><td>
</td>
<td align="right">
<script type="text/javascript"><!--
	  document.write (document.lastModified + "更新")
	  //--></SCRIPT>
</td>
</table>

<hr>



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
		$encryptedpassword = sha256($encryptedpassword);
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


<!-- フッター -->
<p style='clear:both'>
<hr>

<table width="100%">
<tr><td>
</td>
<td align="right">
<script type="text/javascript"><!--
	  document.write (document.lastModified + "更新")
	  //--></SCRIPT>
</td>
</table>

</body>
</html>
