<?php

namespace App\Lib\Excel;

use PHPExcel;
use PHPExcel_IOFactory;

/**
 * Excelクラス(基底クラス)
 */
class ExcelBaseClass{
	
	// Excelオブジェクト
	public  $excel;
	// Excelシート
	public  $sheet;
	// 保存ファイル名
	protected $outPutFileName = 'text.xlsx';
	
	// セルの記号
	protected $cellAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	
	// 保存時のExcelバージョン
	const EXCEL_VER_2007 = 'Excel2007';
	const EXCEL_VER_5 	 = 'Excel5';
	
	/**
	 * コンストラクタ
	 */
	public function __construct(){
		$this->excel = new PHPExcel();
	}
	
	/**
	 * 新規作成(テンプレート不使用)
	 */
	public function createExcel(){
		// シートの作成
		$this->excel->setActiveSheetIndex(0);
		$this->sheet = $this->excel->getActiveSheet();
	}
	
	/**
	 * 新規作成(テンプレート使用)
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	public function createExcelTemplate( $filename ){
        $readObj = PHPExcel_IOFactory::createReader('Excel2007');
        $this->excel = $readObj->load( $filename );

        $this->excel->setActiveSheetIndex(0);
        $this->sheet = $this->excel->getActiveSheet();
	}

	/**
	 * セルに値をセット
	 * @param string $cell セル名
	 * @param string $val  値
	 */
	public function setCell( $cell, $val ){
		$this->sheet->setCellValue( $cell, $val );
	}
	
	/**
	 * セルをマージ
	 * @param  array $cells  セルの一覧
	 * @param  string $val   値	 
	 */
	public function cellMerge( $cells, $val ){
		$this->sheet->mergeCells( $cells );
		$this->setCell( self::leftCell( $cells ), $val );
		//$this->setCell( $cells, $val );
	}
	
	/**
	 * フォントサイズを指定
	 * @param string $cell  セル名
	 * @param integer $size サイズ
	 */
	public function setFontSize( $cell, $size ){
		$this->sheet->getStyle($cell)->getFont()->setSize( $size );
	}
	
	/**
	 * フォントのボールド指定
	 * @param string $cell  セル名
	 * @param boolean $bool 文字を太くするか
	 */
	public function setBold( $cell, $bool ){
		$this->sheet->getStyle($cell)->getFont()->setBold( $bool );
	}
	
	/**
	 * 罫線(上下左右すべて)
	 * @param string $cell セル名
	 */
	public function setBorder( $cell ){
		$this->sheet->getStyle($cell)->getBorders()->getOutline()->setBorderStyle( 'thin' );
	}
		
	/**
	 * 水平寄せ指定
	 * @param string $cell  セル名
	 * @param string $align アライン
	 */
	public function setAlign( $cell, $align = "center" ){
		if( $align == "left" ){
			$this->sheet->getStyle($cell)->getAlignment()->setHorizontal( 'left' );
		}else if( $align == "right" ){
			$this->sheet->getStyle($cell)->getAlignment()->setHorizontal( 'right' );
		}else{
			$this->sheet->getStyle($cell)->getAlignment()->setHorizontal( 'center' );
		}
	}

	/**
	 * ファイルの保存
	 * @param  string $path パス名
	 */
	public function saveFile( $path='' ){
		$write = PHPExcel_IOFactory::createWriter( $this->excel, self::EXCEL_VER_2007 );
		$write->save( $path == '' ? $this->outPutFileName : $path );
	}
	
	/**
	 * ファイルの出力
	 * @param  string $fileName ファイル名
	 */
	public function outputFile( $fileName = '' ){
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="' . ( $fileName == '' ? date('Ymd_H_i_s') : $fileName ) . '.xlsx"');
		
		$write = PHPExcel_IOFactory::createWriter( $this->excel, self::EXCEL_VER_2007 );
		$write->save( 'php://output' );
	}
	
	/**
	 * [readFile description]
	 * @param  string $fileName [description]
	 * @return [type]           [description]
	 */
	public function readFile( $fileName = '' ){
		$readObj = PHPExcel_IOFactory::createReader('Excel2007');
		$excel = $readObj->load( $fileName );
        $excel->setActiveSheetIndex(0);

        $sheet = $excel->getActiveSheet();

        return $sheet;

        //return $readObj->getActiveSheet()->toArray( null, true, true, true );
        //return $this->sheet;
	}

	/**
	 * 値があるかチェック
	 * @param  string $str 文字
	 * @return true or false
	 */
	public static function notNull( $str ){
		if( isset( $str ) && $str != "" ){
			return true;
		}
		return false;
	}
	
	/**
	 * マージセルの左側を取得
	 * @param  string $str 文字
	 * @return セルを取得
	 */
	public static function leftCell( $str ){
		list( $cell, $dmy ) = explode( ':', $str );
		return $cell;
	}
	
}
