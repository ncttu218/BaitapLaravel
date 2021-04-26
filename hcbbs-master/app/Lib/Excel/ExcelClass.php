<?php

namespace App\Lib\Excel;

use App\Lib\Excel\ExcelBaseClass;

/**
 * Excelクラス
 */
class ExcelClass extends ExcelBaseClass{
	
	private $titleCell = "A1"; // タイトルのセル位置
	private $titleValue; // タイトル名
	private $titleFontSize = 16; // タイトルのフォントサイズ
	private $titleBold = true; // タイトルのボールド
	private $defFontSize = 10; // デフォルトフォントサイズ
	private $defFontType = 'ＭＳ Ｐゴシック'; // デフォルトフォントタイプ
	private $lineheight = null; // 指定行の高さを設定する変数
	private $lineNum; // 処理中の行番号
	private $colWidthLong; // 列幅を長めにするカラム番号(_で連結)
	private $header = null; // タイトルのセル位置
	
	/**
	 * コンストラクタ
	 */
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 処理実行
	 * @param  array  $inits    　出力値
	 * @param  array  $midashi1  見出し1
	 * @param  array  $midashi2  見出し2
	 * @param  array  $data      明細の値
	 * @param  array  $goukei    合計
	 */
	public function exec( $inits, $midashi1=array(), $midashi2=array(), $data=array(), $goukei=array() ){
	
		// シートを作成
		$this->createExcel();
		
		// 出力値、パラメータをセット
		$this->setData( $inits );
		
		// タイトル出力
		$this->setTitle();
		
		// 見出し出力
		$this->setMidashi( $midashi1, $midashi2 );
		/*
		// 明細行出力
		$line = $this->setMeisai( $data );
		
		// 合計行出力
		if( count($goukei) ){
			$this->setGoukei( $goukei, $line );
		}
		*/
		// 出力
		$this->outputFile();
	}
	
	/**
	 * タイトルをセット
	 */
	private function setTitle(){
		$this->setBold( $this->titleCell, $this->titleBold ); // フォントのボールド指定
		$this->setFontSize( $this->titleCell, $this->titleFontSize ); // フォントサイズ指定
		$this->setCell( $this->titleCell, $this->titleValue ); // セルに値をセット
	}
	
	/**
	 * 見出しをセット
	 * @param string $midashi1 見出し1
	 * @param string $midashi2 見出し2
	 */
	private function setMidashi( $midashi1, $midashi2 ){
		
		$this->lineNum = 2;
		// 見出し1行目
		if( count($midashi1) ){
			foreach( $midashi1 as $key => $val ){
				if( strpos( $key, ':' ) ){
					$this->cellMerge( $key, $val ); // セルをマージ
				}else{
					$this->setCell( $key, $val ); // セルに値をセット
				}
				$this->setBorder( $key ); // 罫線を描画
				$this->setAlign( $key ); // 水平寄せ
			}
			$this->lineNum++;
		}
		
		// 見出し2行目
		if( count($midashi2) ){
			$index = 0;
			foreach( $midashi2 as $key => $val ){
				if( strpos( $key, ':' ) ){
					$this->cellMerge( $key, $val ); // セルをマージ
					$this->setBorder( $key ); // 罫線を描画
					$this->setAlign( $key ); // 水平寄せ
				}else if( preg_match("[A-Z]", $key ) ){
					$cell = $key;
				}else{
					$cell = substr( $this->cellAlphabet, $index, 1 ) . $this->lineNum;
					$this->setCell( $cell, $val ); // セルに値をセット
					$this->setBorder( $cell ); // 罫線を描画
					$this->setAlign( $cell ); // 水平寄せ
				}
				$index++;
			}
			$this->lineNum++;
		}
	}
	
	/**
	 * 明細行をセット
	 * @param array $data 明細の値
	 */
	private function setMeisai( $data ){
		// 明細部は4行目から
		foreach( $data as $key => $val ){
			$index = 0;
			foreach( $val as $key2 => $val2 ){
				$cell = substr( $this->cellAlphabet, $index, 1 ) . $this->lineNum;
				$this->setCell( $cell, $val2 ); // セルに値をセット
				$this->setBorder( $cell ); // 罫線を描画
				if( $key2 == 'info_title' || $key2 == 'info_body' ){
					$this->setAlign( $cell, 'left' ); // 左寄せ
				}else{
					$this->setAlign( $cell ); // 水平寄せ
				}
				$index++;
			}
			$this->lineNum++;
		}
		return $this->lineNum;
	}
	
	/**
	 * 合計をセット
	 * @param array $goukei 合計
	 * @param integer $line ライン
	 */
	private function setGoukei( $goukei, $line ){
		$index = 0;
		foreach( $goukei as $key => $val ){
			$cell = substr( $this->cellAlphabet, $index, 1 ) . $line;
			$this->setCell( $cell, $val ); // セルに値をセット
			$this->setBorder( $cell ); // 罫線を描画
			$this->setAlign( $cell ); // 水平寄せ
			$index++;
		}
		$line++;
	}
	
	/**
	 * 出力値をセット
	 * @param array $inits 出力値
	 */
	private function setData( $inits ){
		
		$this->titleValue = $inits["titleName"]; // タイトル名
		//if( parent::notNull( $inits["titleCell"] ) ){ // タイトルのセル位置
		if( isset( $inits["titleCell"] ) ){ // タイトルのセル位置
			$this->titleCell = $inits["titleCell"];
		}
		
		//if( parent::notNull( $inits["titleFontSize"] ) ){ // タイトルのフォントサイズ
		if( isset( $inits["titleFontSize"] ) ){ // タイトルのフォントサイズ
			$this->titleFontSize = $inits["titleFontSize"];
		}
		
		//if( parent::notNull( $inits["titleBold"] ) ){ // タイトルのボールド指定
		if( isset( $inits["titleBold"] ) ){ // タイトルのボールド指定
			$this->titleBold = $inits["titleBold"];
		}
		
		//if( parent::notNull( $inits["defFontSize"] ) ){ // デフォルトフォントサイズ
		if( isset( $inits["defFontSize"] ) ){ // デフォルトフォントサイズ
			$this->defFontSize = $inits["defFontSize"];
		}
		
		//if( parent::notNull( $inits["defFontType"] ) ){ // デフォルトフォントタイプ
		if( isset( $inits["defFontType"] ) ){ // デフォルトフォントタイプ
			$this->defFontType = $inits["defFontType"];
		}
		
		//if( parent::notNull( $inits["colWidthLong"] ) ){ // 列幅を長めにするカラム番号(_で連結)
		if( isset( $inits["colWidthLong"] ) ){ // 列幅を長めにするカラム番号(_で連結)
			$this->colWidthLong = explode( '_', $inits["colWidthLong"] );
		}
		
		//if( parent::notNull( $inits["header"] ) ){ // ヘッダー部の追加項目 ※配列
		if( isset( $inits["header"] ) ){ // ヘッダー部の追加項目 ※配列
			$this->header = $inits["header"];
		}
		
		//指定行の高さを設定
		if( isset( $inits["lineheight"] ) ){
			if( is_array( $inits["lineheight"] ) && count( $inits["lineheight"] ) ){
				$this->lineheight = $inits["lineheight"];
			}
		}
		
		// 初期値をセット
		$this->init( $inits["colWidth"], $inits["activeCells"] );
	}
	
	/**
	 * 初期値の設定
	 * @param  integer $colWidth    
	 * @param  string  $activeCells 
	 */
	private function init( $colWidth=16, $activeCells='Z' ){
		$i = 0;
		// 列の横幅を指定
		for( $i = 0; $i<strlen($this->cellAlphabet); $i++ ){
			$width = $colWidth;
			// 列幅を長めにする列(タイトルや本文など)
			if( is_array( $this->colWidthLong ) && count( $this->colWidthLong ) ){
				if( in_array( $i, $this->colWidthLong ) ){
					$width = 40;
				}
			}
			$str = substr( $this->cellAlphabet, $i, 1 );
			$this->sheet->getColumnDimension( $str )->setWidth( $width );
			if( $str == $activeCells ){ break; }
		}
		$this->sheet->getDefaultStyle()->getFont()->setName( $this->defFontType ); // デフォルトフォントタイプ指定
		$this->sheet->getDefaultStyle()->getFont()->setSize( $this->defFontSize ); // デフォルトフォントサイズ指定
		$this->sheet->getDefaultStyle()->getAlignment()->setVertical( 'top' ); // 垂直位置揃えをTOPに設定
		$this->sheet->getDefaultStyle()->getAlignment()->setWrapText( true ); // セルを「折り返して全体を表示」に指定
		
		// ヘッダー部の項目があれば出力
		if( $this->header ){
			foreach( $this->header as $cell => $val ){
				$this->setCell( $cell, $val );
			}
		}
		
		// 指定行の高さを変更する
		if( $this->lineheight ){
			foreach ( $this->lineheight as $key => $val ){
				$this->sheet->getRowDimension( $key )->setHeight( $val );
			}
		}
	}
}