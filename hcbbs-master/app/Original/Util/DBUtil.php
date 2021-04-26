<?php

namespace App\Original\Util;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use DB;

class DBUtil {
    
    /**
    * table作成
    * @param  char $tablename テーブル名
    * @param  array $columns カラム
    */
    public static function makeTable($tablename,$columns) {
        $schema = 'public';
        $table = $schema.'.'.$tablename;
         
        $tableSchema = DB::select('select distinct table_schema,table_name from information_schema.columns where table_schema = ?',[$schema]);
        $tableFound = "ng";
        foreach ($tableSchema as $row){
            if($row->table_schema == $schema && $row->table_name == $tablename){
                $tableFound = "ok";
            }
        }
        if($tableFound == "ng"){
            // テーブル作成
            Schema::create($table, function (Blueprint $table) use($columns){

                $table->increments('id');
                $table->timestamps();
                $table->timestamp('deleted_at')->nullable();

                if (is_array($columns)) {
                    foreach ($columns as $col){
                        self::makeColumn($table, $col['dataType'], $col['name']);
                    }
                }
            });
        }else{
            // カラムチェック、カラム追加
            $tableColumns = DB::select('select b.attname from pg_attribute as b,
                                    (select relid, relname from pg_stat_user_tables where schemaname = ?) as a
                                    where a.relid = b.attrelid and b.attnum > 0 and relname = ?
                                    order by b.attrelid, b.attnum',[$schema,$tablename]);
           
            Schema::table($table, function ($table) use($columns,$tableColumns){

                if (is_array($columns)) {
                    foreach ($columns as $col){
                        $flag = 0;
                        foreach ($tableColumns as $tcol){
                            if($tcol->attname == $col['name']){
                                $flag = 1;
                                break;
                            }
                        }
                        if($flag == 0){
                            self::makeColumn($table, $col['dataType'], $col['name']);
                        }
                    }
                }
            });
        }
    }
    
    /**
    * カラム作成
    * @param  char $table テーブル名
    * @param  char $columns カラムタイプ
    * @param  char $columns カラム
    */
   private static function makeColumn($table,$type,$col) {
        switch ($type){
        case 'text':
            $table->text($col)->nullable();
            break;
        case 'date':
            $table->date($col)->nullable();
            break;
        case 'timestamp':
            $table->timestamp($col)->nullable();
            break;
        case 'file':
            $table->text($col)->nullable();
            break;
        case 'time':
            $table->timestamp($col)->nullable();
            break;
        case 'integer':
            $table->integer($col)->nullable();
            break;
        default;
            echo "err = ".$col;
        }
    }
    
}