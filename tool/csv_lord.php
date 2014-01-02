<?php
//--------------------------------------------------
// 各種csv読み込み
// csvを読み込んで変数に入れ込むクラス
//--------------------------------------------------

class csv_lord {
	public $csv_data;
	
	function __construct($file_pass) {
		
		try {
			
			//読み込むファイルの例外チェック
			if (pathinfo($file_pass, PATHINFO_EXTENSION) !== "csv") {
				throw new Exception("CSVファイルじゃないみたい");
			}
			
			// csvを開く
			$csv_file = fopen( $file_pass , "r" );
			
			// ジョブスキルの情報を取得
			$row = 0;
			while( ( $lines = $this->fgetcsv_reg( $csv_file, 1000 ) ) !== false ){
				$num = count($lines);
				for($i=0 ; $i<$num ; $i++){
	//				$lines[$i] = mb_convert_encoding($lines[$i], "UTF-8", "auto");
					$this->csv_data[$row][$i] = $lines[$i];
				}
				$row++ ;
			}
			
			// csvを閉じる
			fclose($csv_file);
		} catch (Exception $e) {
			echo '<p>捕捉した例外: '.$e->getMessage().'</p>';
		}
	}
	
	
	//////////////////////////////////////////////////////
	// fgetcsvの文字コードを解決するおまじない関数
	//////////////////////////////////////////////////////
	
	 function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"') {
	   $d = preg_quote($d);
	   $e = preg_quote($e);
	   $_line = "";
	   $eof = "";
	   while (($eof != true)and(!feof($handle))) {
	      $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
	      $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
	      if ($itemcnt % 2 == 0) $eof = true;
	  }
	  $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
	  $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
	  preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	  $_csv_data = $_csv_matches[1];
	  for($_csv_i=0; $_csv_i<count($_csv_data); $_csv_i++) {
	     $_csv_data[$_csv_i] = preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
	      $_csv_data[$_csv_i] = str_replace($e.$e, $e, $_csv_data[$_csv_i]);
	  }
	  return empty($_line) ? false : $_csv_data;
	}
}










?>