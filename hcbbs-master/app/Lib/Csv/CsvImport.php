<?php

namespace app\Lib\Csv;

use App\Lib\Csv\CsvImportResult;
use Log;
use SplFileObject;

/**
 * CSVのアップロードの処理の本体
 */
class CsvImport{

    /**
     * コンストラクタ
     * @param iParser $parser    [description]
     * @param [type]  $filePath  ファイルパス
     * @param [type]  $parameter 画面入力値及びCSVインポート時に使用する値
     * @param integer $start     読み込み開始位置
     */
    private function __construct( iParser $parser, $filePath, $parameter=null, $start=0 ){
        $this->parser = $parser;
        $this->filePath = $filePath; // ファイルパス
        $this->parameter = $parameter; // 検索条件を取得
        $this->start = $start; // 読み飛ばす列数

        $this->result = new CsvImportResult();

        // CSVファイルを扱う際の便利オブジェクト
        $this->csvFileObj = new SplFileObject( $this->filePath );
        $this->csvFileObj->setFlags( SplFileObject::READ_CSV );

        // 値の追加と編集を行うカラムを格納する変数
        $this->columnList = [];
    }

    /**
     * 自分自身のオブジェクトを返す
     * @param  iParser $parser    [description]
     * @param  [type]  $filePath  ファイルパス
     * @param  [type]  $parameter 画面入力値及びCSVインポート時に使用する値
     * @param  integer $start     読み込み開始位置
     * @return [type]             [description]
     */
    public static function getInstance( iParser $parser, $filePath, $parameter=null, $start=0 ){
        Log::debug('getInstance!');

        // 自分自身のインスタンスを返す
        return new CsvImport( $parser, $filePath, $parameter, $start );
    }

    /**
     * csvのデータをDBに登録するメソッド
     *
     * $line => csvの1行分の配列
     * $soreData => csv1行分の連想配列（キーはDBのカラム名）
     */
    public function execute(){
        Log::debug('execute!');

        // 総数を保持
        $totalCount = 0;

        // 値の追加と編集を行うカラムを取得
        $this->columnList = collect( $this->parser->getColumns() );

        foreach( $this->csvFileObj as $row_num => $line ){
            Log::debug('row=' . $row_num . 'start=' . $this->start );

            if( $row_num >= $this->start ) {
                // DBに登録用にエンコードを指定
                mb_convert_variables( 'UTF-8', 'SJIS-win', $line );
                
                // 値が入っているかを確認する為に配列の値を文字列に変換
                $lineText = implode( $line, "" );

                // 1行目が空でなければ動作
                if( !empty( $lineText ) == True ){
                    // 総数を加算
                    $totalCount += 1;

                    // 予め設定されているCSV項目数を比較
                    if( $this->isOkColsNum( $line ) == True ){
                        // ここでデータがおかしくなっている可能性あり。
                        list( $storeData, $errors ) = $this->parser->validate( $line );

                        // エラーがあれば
                        if( !empty( $errors ) ) {
                            // エラーをストック
                            $this->result->addError( $this->genMessage( $row_num, $line, $errors ) );

                        } else {
                            #try {
                                // CSV外の値を加工した値を取得
                                $storeData = $this->parser->inject( $storeData, $this->parameter );
                                
                                // 値の登録を行う
                                $this->parser->store( $storeData );

                                // 成功データとしてバッファに追加
                                $this->result->add( $storeData );

                            #} catch( Exception $e ){
                                // なんらかのエラーが発生した場合
                            #    $this->result->addError( $this->genMessage( $row_num, $line, $e->getMessage() ) );

                            #}
                        }

                    } else {
                        $this->result->addError(
                            $this->genMessage(
                                $row_num,
                                $line,
                                ["カラムの数が合いません(想定：" . $this->parser->getItemNum() . " 実際：" . count( $line ) . ")"]
                            )
                        );
                    }
                }
            }
        }

        // 総件数の設定
        $this->result->setTotalCount( $totalCount );
    }
    
    /**
     * [isWrite description]
     * @param  [type]  $no [description]
     * @return boolean     [description]
     */
    protected function isWrite( $no ){
        return $this->columnList->has( $no );
    }

    /**
     * アップロードされたcsvのヘッダの数と
     * 予め設定されているCSV項目数を比較
     * @param  [type]  $line [description]
     * @return boolean       [description]
     */
    protected function isOkColsNum( $line ){
        Log::debug('item=' . $this->parser->getItemNum() );
        Log::debug('line cols=' . count($line));

        return $this->parser->getItemNum() == count( $line );
    }

    /**
     * エラーメッセーを生成するメソッド
     * @param  int $row
     * @param   $line    エラー行
     * @param   $message エラーメッセージ
     * @return  array
     */
    protected function genMessage( $row, $line, $message ){
        return array(
            'row' => $row + 1,
            'line' => implode( ',', $line ),
            'message' => implode( ',', $message )
        );
    }

}
