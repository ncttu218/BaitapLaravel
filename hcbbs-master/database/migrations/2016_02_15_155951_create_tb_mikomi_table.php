<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbMikomiTable extends Migration {

	/**
	 * tb_mikomiを作成するコマンド
	 * インポートするデータ
	 * ・見込客・Hot客.csv
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_mikomi');
		Schema::create('tb_mikomi', function(Blueprint $table) {
			$table->increments('id');
			$table->string('mkm_inspection_ym');
			$table->string('mkm_base_code', 2)->nullable();
			$table->string('mkm_base_name')->nullable();
			$table->string('mkm_user_id', 3)->nullable();
			$table->string('mkm_user_name')->nullable();
			$table->string('mkm_customer_code')->nullable();
			$table->string('mkm_customer_name')->nullable();
			$table->date('mkm_mikomi_reg_date')->nullable();
			$table->date('mkm_mikomi_reg_remove_date')->nullable();
			$table->string('mkm_car_name')->nullable();
			$table->string('mkm_car_name_2')->nullable();
			$table->date('mkm_hikitsugi_saki_reg_date')->nullable();
			$table->string('mkm_hikitsugi_saki_user_id')->nullable();
			$table->string('mkm_hikitsugi_saki_user_name')->nullable();
			$table->date('mkm_hikitsugi_moto_reg_date')->nullable();
			$table->string('mkm_hikitsugi_moto_user_id')->nullable();
			$table->string('mkm_hikitsugi_moto_user_name')->nullable();
			$table->date('mkm_result_plan_date')->nullable();
			$table->string('mkm_car_manage_number')->nullable();
			$table->string('mkm_customer_address')->nullable();
			$table->string('mkm_customer_tel')->nullable();
			$table->string('mkm_customer_office_tel')->nullable();
			$table->string('mkm_car_base_number')->nullable();
			$table->integer('mkm_syaken_times')->nullable()->default(0);
			$table->date('mkm_syaken_next_date')->nullable();
			$table->date('mkm_contact_day')->nullable();
			$table->string('mkm_contact_time')->nullable();
			$table->integer('mkm_status')->nullable()->default(0);
			$table->string('mkm_action')->nullable();
			$table->text('mkm_memo')->nullable();
			$table->date('mkm_hot_reg_date')->nullable();
			$table->date('mkm_seiyaku_reg_date')->nullable();

			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_mikomi.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_inspection_ym IS '対象年月'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_base_code IS '担当者所属拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_base_name IS '担当者所属拠点名略称'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_user_id IS '顧客担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_user_name IS '顧客担当者氏名（漢字）'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_customer_name IS '顧客氏名（漢字）'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_mikomi_reg_date IS '＊見込客登録日 YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_mikomi_reg_remove_date IS '＊見込客取消日 YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_car_name IS '車名（カナ）'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_car_name_2 IS '車名カナ（８桁）'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hikitsugi_saki_reg_date IS '＊引継出発生日 YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hikitsugi_saki_user_id IS '引継先担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hikitsugi_saki_user_name IS '引継先担当者氏名（漢字）'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hikitsugi_moto_reg_date IS '＊引継受発生日 YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hikitsugi_moto_user_id IS '引継元担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hikitsugi_moto_user_name IS '引継元担当者氏名（漢字）'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_result_plan_date IS '＊販売予定結果実績日 YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_car_manage_number IS '統合車両管理ＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_customer_address IS '＊自宅住所'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_customer_tel IS '＊自宅電話番号'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_customer_office_tel IS '＊勤務先電話番号'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_car_base_number IS '＊車両基本登録No'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_syaken_times IS '車検回数'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_syaken_next_date IS '＊次回車検日　YYYY/MM/DD'");

		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_contact_day IS '連絡日'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_contact_time IS '連絡時間'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_status IS '意向結果'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_action IS '活動内容'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_memo IS '備考'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_hot_reg_date IS 'Hot予定日'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.mkm_seiyaku_reg_date IS '成約日'");

		DB::statement("COMMENT ON COLUMN tb_mikomi.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_mikomi.updated_by IS '更新者'");

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
