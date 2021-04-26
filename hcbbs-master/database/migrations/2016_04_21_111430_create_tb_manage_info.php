<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbManageInfo extends Migration {

	/**
	 * tb_manage_infoの作成コマンド
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_manage_info');
		Schema::create('tb_manage_info', function(Blueprint $table) {
			$table->increments('id');
			$table->string('mi_syaken_next_ym');
			$table->integer('mi_customer_id')->nullable();
			$table->string('mi_car_manage_number');
			$table->string('mi_base_code')->nullable();
			$table->string('mi_user_id')->nullable();
			$table->string('mi_customer_code')->nullable();
			$table->string('mi_car_base_number')->nullable();
			$table->string('mi_car_frame_number')->nullable();
			$table->integer('mi_syaken_times')->nullable();
			$table->date('mi_syaken_next_date')->nullable();
			$table->string('mi_customer_kouryaku_flg')->nullable();
			$table->string('mi_abc_abc')->nullable();
			$table->string('mi_ciao_number')->nullable();
			$table->string('mi_ciao_course')->nullable();
			$table->date('mi_ciao_first_regist_date_ym')->nullable();
			$table->date('mi_ciao_syaken_manryo_date')->nullable();
			$table->date('mi_ciao_syaken_next_date')->nullable();
			$table->string('mi_ciao_money')->nullable();
			$table->date('mi_ciao_start_date')->nullable();
			$table->date('mi_ciao_end_date')->nullable();
			$table->string('mi_ciao_jisshi_type')->nullable();
			$table->string('mi_ciao_jisshi_yotei')->nullable();
			$table->string('mi_ciao_jisshi')->nullable();
			$table->string('mi_ciao_jisshi_flg')->nullable();
			$table->string('mi_ciao_course_keizoku')->nullable();
			$table->string('mi_ciao_kaiinsyou_hakkou_date')->nullable();
			$table->string('mi_tmr_last_process_status')->nullable();
			$table->date('mi_tmr_last_call_result')->nullable();
			$table->string('mi_tmr_call_times')->nullable();
			$table->string('mi_tmr_last_call_date')->nullable();
			$table->string('mi_tmr_to_base_comment')->nullable();
			$table->string('mi_tmr_in_sub_intention')->nullable();
			$table->string('mi_tmr_in_sub_detail')->nullable();
			$table->string('mi_tmr_call_1_status')->nullable();
			$table->string('mi_tmr_call_1_result')->nullable();
			$table->date('mi_tmr_call_1_date')->nullable();
			$table->string('mi_tmr_call_2_status')->nullable();
			$table->string('mi_tmr_call_2_result')->nullable();
			$table->date('mi_tmr_call_2_date')->nullable();
			$table->string('mi_tmr_call_3_status')->nullable();
			$table->string('mi_tmr_call_3_result')->nullable();
			$table->date('mi_tmr_call_3_date')->nullable();
			$table->string('mi_tmr_call_4_status')->nullable();
			$table->string('mi_tmr_call_4_result')->nullable();
			$table->date('mi_tmr_call_4_date')->nullable();
			$table->string('mi_tmr_call_5_status')->nullable();
			$table->string('mi_tmr_call_5_result')->nullable();
			$table->date('mi_tmr_call_5_date')->nullable();
			$table->string('mi_tmr_call_6_status')->nullable();
			$table->string('mi_tmr_call_6_result')->nullable();
			$table->date('mi_tmr_call_6_date')->nullable();
			$table->date('mi_mt_syaken_ikou_date')->nullable();
			$table->string('mi_mt_syaken_ikou')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});

		DB::statement("COMMENT ON COLUMN tb_maintenance.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_syaken_next_ym IS '車検年月'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_customer_id IS 'tb_customertのID'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_car_manage_number IS '統合車両管理ＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_car_base_number IS '＊車両基本登録No'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_car_frame_number IS 'フレームＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_syaken_times IS '車検回数'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_syaken_next_date IS '＊次回車検日　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_customer_kouryaku_flg IS '攻略対象車'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_abc_abc IS 'ABCゾーン'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_number IS '申込番号'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_course IS '加入コース'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_first_regist_date_ym IS '初度登録年月日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_syaken_manryo_date IS '車検起算日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_syaken_next_date IS '車検満了日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_money IS '加入金額'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_start_date IS '会員証有効期間始期'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_end_date IS '会員証有効期間終期'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_jisshi_type IS '最終点検種別'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_jisshi_yotei IS '最終点検実施予定'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_jisshi IS '最終点検実施'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_jisshi_flg IS '実施フラグ'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_course_keizoku IS '継続加入継続加入コース'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_ciao_kaiinsyou_hakkou_date IS '継続加入会員証発行日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_last_process_status IS '最終処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_last_call_result IS '最終架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_times IS '架電回数'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_last_call_date IS '最終架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_to_base_comment IS '拠点への申送事項'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_in_sub_intention IS '入庫/代替意向'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_in_sub_detail IS '入庫/代替詳細'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_1_status IS '1コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_1_result IS '1コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_1_date IS '1コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_2_status IS '2コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_2_result IS '2コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_2_date IS '2コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_3_status IS '3コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_3_result IS '3コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_3_date IS '3コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_4_status IS '4コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_4_result IS '4コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_4_date IS '4コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_5_status IS '5コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_5_result IS '5コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_5_date IS '5コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_6_status IS '6コール目処理状況'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_6_result IS '6コール目架電結果'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_tmr_call_6_date IS '6コール目架電日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_mt_syaken_ikou_date IS '意向確認日'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.mi_mt_syaken_ikou IS '車検意向区分(1=自社,2=他社)'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_manage_info.updated_by IS '更新者'");
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
