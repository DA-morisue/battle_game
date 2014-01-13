<?php
require_once './include/session.php';
require_once './tool/csv_lord.php';

//----------------------------------------
// 防具テーブルデータ更新
//----------------------------------------

if ($_POST['db_update_wear']) {
	$table_list = array(
			"head_data",
			"body_data",
			"arm_data",
			"waist_data",
			"leg_data"
	);

	foreach ($table_list as $table_name) {
		$csv_data = new csv_lord('./csv/'.$table_name.'.csv');
		update_wear($table_name, $csv_data->csv_data);
	}
}

function update_wear( $table_name , $csv_data) {
		
	// DB接続
	$db_link = db_access();
	
	// テーブルのデータを削除
	$sql = 'TRUNCATE TABLE '.$table_name;
	$sth = $db_link->prepare($sql);
	$sth->execute();
		
	for ($i = 1; $i < count($csv_data)-1; $i++) {

		// 新規にデータをインポート
		$sql = 'INSERT INTO '.$table_name.'(
			id,
			name,
			sex,
			type,
			rere,
			slot,
			get_multi,
			get_single,
			def,
			max_def,
			def_fire,
			def_water,
			def_thunder,
			def_ice,
			def_dragon,
			skill_01,
			skill_point_01,
			skill_02,
			skill_point_02,
			skill_03,
			skill_point_03,
			skill_04,
			skill_point_04,
			skill_05,
			skill_point_05,
			material_01,
			material_count_01,
			material_02,
			material_count_02,
			material_03,
			material_count_03,
			material_04,
			material_count_04
		) VALUES (
			:id,
			:name,
			:sex,
			:type,
			:rere,
			:slot,
			:get_multi,
			:get_single,
			:def,
			:max_def,
			:def_fire,
			:def_water,
			:def_thunder,
			:def_ice,
			:def_dragon,
			:skill_01,
			:skill_point_01,
			:skill_02,
			:skill_point_02,
			:skill_03,
			:skill_point_03,
			:skill_04,
			:skill_point_04,
			:skill_05,
			:skill_point_05,
			:material_01,
			:material_count_01,
			:material_02,
			:material_count_02,
			:material_03,
			:material_count_03,
			:material_04,
			:material_count_04
			)';
		$sth = $db_link->prepare($sql);

		$sth->bindValue(':id'                , $csv_data[$i][0]  , PDO::PARAM_INT);
 		$sth->bindValue(':name'              , $csv_data[$i][1]  , PDO::PARAM_STR);
		$sth->bindValue(':sex'               , $csv_data[$i][2]  , PDO::PARAM_INT);
		$sth->bindValue(':type'              , $csv_data[$i][3]  , PDO::PARAM_INT);
		$sth->bindValue(':rere'              , $csv_data[$i][4]  , PDO::PARAM_INT);
		$sth->bindValue(':slot'              , $csv_data[$i][5]  , PDO::PARAM_INT);
		$sth->bindValue(':get_multi'         , $csv_data[$i][6]  , PDO::PARAM_INT);
		$sth->bindValue(':get_single'        , $csv_data[$i][7]  , PDO::PARAM_INT);
		$sth->bindValue(':def'               , $csv_data[$i][8]  , PDO::PARAM_INT);
		$sth->bindValue(':max_def'           , $csv_data[$i][9]  , PDO::PARAM_INT);
		$sth->bindValue(':def_fire'          , $csv_data[$i][10] , PDO::PARAM_INT);
		$sth->bindValue(':def_water'         , $csv_data[$i][11] , PDO::PARAM_INT);
		$sth->bindValue(':def_thunder'       , $csv_data[$i][12] , PDO::PARAM_INT);
		$sth->bindValue(':def_ice'           , $csv_data[$i][13] , PDO::PARAM_INT);
		$sth->bindValue(':def_dragon'        , $csv_data[$i][14] , PDO::PARAM_INT);
		$sth->bindValue(':skill_01'          , $csv_data[$i][15] , PDO::PARAM_STR);
		$sth->bindValue(':skill_point_01'    , $csv_data[$i][16] , PDO::PARAM_INT);
		$sth->bindValue(':skill_02'          , $csv_data[$i][17] , PDO::PARAM_STR);
		$sth->bindValue(':skill_point_02'    , $csv_data[$i][18] , PDO::PARAM_INT);
		$sth->bindValue(':skill_03'          , $csv_data[$i][19] , PDO::PARAM_STR);
		$sth->bindValue(':skill_point_03'    , $csv_data[$i][20] , PDO::PARAM_INT);
		$sth->bindValue(':skill_04'          , $csv_data[$i][21] , PDO::PARAM_STR);
		$sth->bindValue(':skill_point_04'    , $csv_data[$i][22] , PDO::PARAM_INT);
		$sth->bindValue(':skill_05'          , $csv_data[$i][23] , PDO::PARAM_STR);
		$sth->bindValue(':skill_point_05'    , $csv_data[$i][24] , PDO::PARAM_INT);
		$sth->bindValue(':material_01'       , $csv_data[$i][25] , PDO::PARAM_STR);
		$sth->bindValue(':material_count_01' , $csv_data[$i][26] , PDO::PARAM_INT);
		$sth->bindValue(':material_02'       , $csv_data[$i][27] , PDO::PARAM_STR);
		$sth->bindValue(':material_count_02' , $csv_data[$i][28] , PDO::PARAM_INT);
		$sth->bindValue(':material_03'       , $csv_data[$i][29] , PDO::PARAM_STR);
		$sth->bindValue(':material_count_03' , $csv_data[$i][30] , PDO::PARAM_INT);
		$sth->bindValue(':material_04'       , $csv_data[$i][31] , PDO::PARAM_STR);
		$sth->bindValue(':material_count_04' , $csv_data[$i][32] , PDO::PARAM_INT);
		
		$sth->execute();
	}
	echo '防具[ '.$table_name.' ]データベースを更新しました<br>';

	// DB切断
	db_close($db_link);
}


//----------------------------------------
// スキルテーブルデータ更新
//----------------------------------------

if ($_POST['db_update_skill']) {
	$csv_data = new csv_lord('./csv/skill_data.csv');
	update_skill('skill_data', $csv_data->csv_data);
}

function update_skill( $table_name , $csv_data) {

	// DB接続
	$db_link = db_access();

	// テーブルのデータを削除
	$sql = 'TRUNCATE TABLE '.$table_name;
	$sth = $db_link->prepare($sql);
	$sth->execute();

	for ($i = 1; $i < count($csv_data)-1; $i++) {

		// 新規にデータをインポート
		$sql = 'INSERT INTO '.$table_name.'(
			id,
			label,	
			name,
			category,	
			skill_point,	
			type
		) VALUES (
			:id,
			:label,	
			:name,
			:category,	
			:skill_point,	
			:type
			)';
		$sth = $db_link->prepare($sql);

		$sth->bindValue(':id'                , $csv_data[$i][0]  , PDO::PARAM_INT);
		$sth->bindValue(':label'	         , $csv_data[$i][1]  , PDO::PARAM_STR);
		$sth->bindValue(':name'              , $csv_data[$i][2]  , PDO::PARAM_INT);
		$sth->bindValue(':category'	         , $csv_data[$i][3]  , PDO::PARAM_INT);
		$sth->bindValue(':skill_point'       , $csv_data[$i][4]  , PDO::PARAM_INT);
		$sth->bindValue(':type'              , $csv_data[$i][5]  , PDO::PARAM_INT);
		
		$sth->execute();
	}
	echo 'スキルデータベースを更新しました';
	
	// DB切断
	db_close($db_link);
}

?>