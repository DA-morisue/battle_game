<?php
require_once './tool/csv_lord.php';

//CSV読み込み
$csv_data = new csv_lord('./csv/MH4EQUIP_HEAD.csv');
dump_html($csv_data->csv_data[0]);
dump_html($csv_data->csv_data[1]);

//DBインポート
$db_link = $db_access();


//DBアップデート




?>