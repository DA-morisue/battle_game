<?php
//----------------------------------------
//
// キャラ情報取得クラス
//
//----------------------------------------

class chara{
	public $chara_data;
	public $wepon_data;
	public $head_data;
	public $body_data;
	public $arm_data;
	public $waist_data;
	public $leg_data;
	
	//--------------------------------------------
	// キャラ情報初期化処理
	//--------------------------------------------
	function __construct($chara_id) {
		// DBからキャラ情報を取得
		$db_link = db_access();
		$sth = $db_link->prepare('SELECT * FROM charactor WHERE id = :chara_id');
		$sth->bindValue(':chara_id' , $chara_id , PDO::PARAM_INT);
		$sth->execute();

		$this->chara_data = $sth->fetch();

		// 装備品の情報を取得
		$wear_type = array( head , body , arm , waist , leg );
		foreach ($wear_type as $type) {
			$sql = 'SELECT * FROM '.$type.'_data WHERE id = :wear_id ';
			$sth = $db_link->prepare( $sql );
			$sth->bindValue(':wear_id', $this->chara_data['equip_'.$type] , PDO::PARAM_INT);
			$sth->execute();
			$this->{$type.'_data'} = $sth->fetch();
		}

		// DB切断処理
		db_close($db_link);
	}

	//--------------------------------------------
	// 武器装備処理
	//--------------------------------------------
	function equip_weapon( $weapon_id ) {
		;
	}

	//--------------------------------------------
	// 防具装備処理
	//--------------------------------------------
	function equip_wear( $wear_type , $wear_id) {

		// DBに接続
		$db_link = db_access();

		// 外す装備品の情報を取得
		$remove_wear_data = $this->{$wear_type.'_data'};

		// 装備する装備品の情報を取得
		$sql = 'SELECT * FROM '.$wear_type.'_data WHERE id = :wear_id ';
		$sth = $db_link->prepare( $sql );
		$sth->bindValue(':wear_id', $wear_id , PDO::PARAM_INT);
		$sth->execute();
		$equip_wear_data = $sth->fetch();

		$this->{$wear_type.'_data'} = $equip_wear_data;

		// 装備パラメータを反映
		$this->chara_data['def']         = $this->chara_data['def']         - $remove_wear_data['def'] + $equip_wear_data['def'];
		$this->chara_data['def_fire']    = $this->chara_data['def_fire']    - $remove_wear_data['def_fire'] + $equip_wear_data['def_fire'];
		$this->chara_data['def_water']   = $this->chara_data['def_water']   - $remove_wear_data['def_water'] + $equip_wear_data['def_water'];
		$this->chara_data['def_thunder'] = $this->chara_data['def_thunder'] - $remove_wear_data['def_thunder'] + $equip_wear_data['def_thunder'];
		$this->chara_data['def_ice']     = $this->chara_data['def_ice']     - $remove_wear_data['def_ice'] + $equip_wear_data['def_ice'];
		$this->chara_data['def_dragon']  = $this->chara_data['def_dragon']  - $remove_wear_data['def_dragon'] + $equip_wear_data['def_dragon'];


		// 装備した後のパラメータをDBに反映
		$id = $this->chara_data['id'];
		$sql = 'UPDATE charactor SET
				equip_'.$wear_type.' = :wear_id ,
				def                  = :def ,
				def_fire             = :def_fire ,
				def_water            = :def_water ,
				def_thunder          = :def_thunder ,
				def_ice              = :def_ice ,
				def_dragon           = :def_dragon
			WHERE
				id = '.$id
				;

				$sth = $db_link->prepare( $sql );
				$sth->bindValue(':wear_id'     , $wear_id                 , PDO::PARAM_INT);
				$sth->bindValue(':def'         , $this->chara_data['def']         , PDO::PARAM_INT);
				$sth->bindValue(':def_fire'    , $this->chara_data['def_fire']    , PDO::PARAM_INT);
				$sth->bindValue(':def_water'   , $this->chara_data['def_water']   , PDO::PARAM_INT);
				$sth->bindValue(':def_thunder' , $this->chara_data['def_thunder'] , PDO::PARAM_INT);
				$sth->bindValue(':def_ice'     , $this->chara_data['def_ice']     , PDO::PARAM_INT);
				$sth->bindValue(':def_dragon'  , $this->chara_data['def_dragon']  , PDO::PARAM_INT);
				$sth->execute();

				// DB切断処理
				db_close($db_link);

	}
}
?>