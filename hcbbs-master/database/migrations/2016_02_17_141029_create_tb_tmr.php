<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTmr extends Migration {

	/**
	 * tb_tmrを作成するコマンド
	 * インポートするデータ
	 * ・TMR架電結果リスト.csv
	 * ※2016年8月16日現在使っていない
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_tmr');
		Schema::create('tb_tmr', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tmr_base_code', 2)->nullable();
			$table->string('tmr_user_id', 3)->nullable();
			$table->string('tmr_customer_code')->nullable();
			$table->string('tmr_custmer_name')->nullable();
			$table->string('tmr_manage_number')->nullable();
			$table->date('tmr_syaken_next_date')->nullable();
			$table->string('tmr_last_process_status')->nullable();
			$table->string('tmr_last_call_result')->nullable();
			$table->string('tmr_call_times')->nullable();
			$table->date('tmr_last_call_date')->nullable();
			$table->string('tmr_to_base_comment')->nullable();
			$table->string('tmr_in_sub_intention')->nullable();
			$table->string('tmr_in_sub_detail')->nullable();
			$table->string('tmr_call_1_status')->nullable();
			$table->string('tmr_call_1_result')->nullable();
			$table->date('tmr_call_1_date')->nullable();
			$table->string('tmr_call_2_status')->nullable();
			$table->string('tmr_call_2_result')->nullable();
			$table->date('tmr_call_2_date')->nullable();
			$table->string('tmr_call_3_status')->nullable();
			$table->string('tmr_call_3_result')->nullable();
			$table->date('tmr_call_3_date')->nullable();
			$table->string('tmr_call_4_status')->nullable();
			$table->string('tmr_call_4_result')->nullable();
			$table->date('tmr_call_4_date')->nullable();
			$table->string('tmr_call_5_status')->nullable();
			$table->string('tmr_call_5_result')->nullable();
			$table->date('tmr_call_5_date')->nullable();
			$table->string('tmr_call_6_status')->nullable();
			$table->string('tmr_call_6_result')->nullable();
			$table->date('tmr_call_6_date')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_tmr.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_base_code IS '拠点CD'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_user_id IS '担当者CD'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_customer_code IS '顧客CD'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_custmer_name IS '顧客氏名'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_manage_number IS '統合車両管理No.'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_syaken_next_date IS '次回車検日 YYYY/MM/dd'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_last_process_status IS '最終処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_last_call_result IS '最終架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_times IS '架電回数'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_last_call_date IS '最終架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_to_base_comment IS '拠点への申送事項'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_in_sub_intention IS '入庫/代替意向'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_in_sub_detail IS '入庫/代替詳細'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_1_status IS '1コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_1_result IS '1コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_1_date IS '1コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_2_status IS '2コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_2_result IS '2コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_2_date IS '2コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_3_status IS '3コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_3_result IS '3コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_3_date IS '3コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_4_status IS '4コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_4_result IS '4コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_4_date IS '4コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_5_status IS '5コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_5_result IS '5コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_5_date IS '5コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_6_status IS '6コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_6_result IS '6コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_tmr.tmr_call_6_date IS '6コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_tmr.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_tmr.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_tmr.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_tmr.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_tmr.updated_by IS '更新者'");


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
