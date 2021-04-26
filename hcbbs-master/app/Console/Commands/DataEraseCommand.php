<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;
use DB;

class DataEraseCommand extends Command {

    use DispatchesJobs;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data-erase';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'ブログデータの自動削除コマンド';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
        // 記事データの自動削除用のパラメータ 
        $dataeraseList = config('original.dataerase_para');
        // パラメータから値を取得するループ
        foreach( $dataeraseList as $value ){
            $table_name = 'tb_' . $value['table_name']; // テーブル名
            $key_column = $value['key_column']; // キーになるカラム名
            $timespan = $value['timespan']; // 削除するまでの期間
            $erace_method = $value['erace_method']; // 削除方法

            // 削除期間の設定
            $timelimit = "to_date( {$key_column}::text,'YYYY/MM/DD' ) < current_timestamp - interval '{$timespan}' ";
            
            //delete の場合　id_deleteのテーブルを作りそこへ移動
            if( $erace_method == 'delete' ){
                $count = 0;
                // 削除用テーブルの存在チェック、なければテーブル作成
                $sql = "SELECT count(*) FROM pg_tables WHERE tablename = '{$table_name}_delete' ";
                $result = DB::select( $sql );
                $count = $result[0]->count;
                // 削除受けテーブル作成
                // fwrite($fp, "detacheck:{$count}\n");
                if($count < 1){
                    $sql = "SELECT * INTO {$table_name}_delete FROM {$table_name} WHERE number = 'data000000' ";
                    // fwrite($fp, "$sql\n");
                    $result = DB::select( $sql );
                }

                // データを削除受けテーブルに移動
                // スタッフブログの場合はブログ部分(treepathがあるもの)のみ削除
                if(preg_match("/staff/",$table_name)){
                    $sql = "INSERT INTO {$table_name}_delete SELECT * FROM {$table_name} WHERE {$timelimit} AND treepath like 'data%' ";
                }else{
                    $sql = "INSERT INTO {$table_name}_delete SELECT * FROM {$table_name} WHERE {$timelimit} ";
                }
                // fwrite($fp, "$sql\n");
                $result = DB::insert( $sql );

                // テータを削除
                // スタッフブログの場合はブログ部分(treepathがあるもの)のみ削除
                if(preg_match("/staff/",$table_name)){
                    $sql = "DELETE FROM {$table_name} WHERE {$timelimit} AND treepath like 'data%' ";
                }else{
                    $sql = "DELETE FROM {$table_name} WHERE {$timelimit} ";
                }
                // fwrite($fp, "$sql\n");
                $result = DB::delete( $sql );
            }

            // timelimitの場合　公開期間を設ける（日付２・年,日付２・月,日付２・日のカラムが公開完了日なのでここへ日付を設定）
            if( $erace_method == 'timelimit' ){
                $timefield = " to_date = to_char( to_date( {$key_column}::text ,'YYYY/MM/DD') + interval '{$timespan}','YYYY/MM/DD' )::timestamp ";
                $sql = " UPDATE {$table_name} SET {$timefield} WHERE {$timelimit} AND to_date IS NULL ";
                // fwrite($fp, "$sql\n");
                $result = DB::update( $sql );
            }
        }
    }
}