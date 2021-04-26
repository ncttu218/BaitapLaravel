<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatetTbResultCars extends Migration {

	/**
	 * tb_result_carsを作成するコマンド
	 * インポートするデータ
	 * ・v_syaken_result
	 * ・v_tenken_ansin_kaiteki_result
	 * ・v_tenken_houtei_12_result
	 * ・v_tenken_muryou6_result
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_result_cars');
		Schema::create('tb_result_cars', function(Blueprint $table) {
			$table->increments('id');

			$table->integer('rstc_inspection_id');
			$table->string('rstc_inspection_ym');
			$table->integer('rstc_customer_id')->nullable();
			$table->string('rstc_base_code')->nullable();
			$table->timestamp('rstc_accept_date')->nullable();
			$table->string('rstc_customer_code')->nullable();
			$table->string('rstc_customer_name')->nullable();
			$table->string('rstc_user_id')->nullable();
			$table->string('rstc_user_name')->nullable();
			$table->string('rstc_user_base_code')->nullable();
			$table->string('rstc_car_name')->nullable();
			$table->string('rstc_manage_number');
			$table->timestamp('rstc_start_date')->nullable();
			$table->timestamp('rstc_end_date')->nullable();
			$table->string('rstc_detail')->nullable();
			$table->string('rstc_hosyo_kbn')->nullable();
			$table->string('rstc_youmei')->nullable();
			$table->timestamp('rstc_put_in_date')->nullable();
			$table->timestamp('rstc_get_out_date')->nullable();
			$table->timestamp('rstc_reserve_commit_date')->nullable();
			$table->string('rstc_reserve_status')->nullable();
			$table->timestamp('rstc_work_put_date')->nullable();
			$table->timestamp('rstc_delivered_date')->nullable();
			$table->date('rstc_syaken_next_date')->nullable();
			$table->string('rstc_web_reserv_flg')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');

		});
		DB::statement("COMMENT ON COLUMN tb_result_cars.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_inspection_id IS '車点検区分'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_inspection_ym IS '対象年月'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_customer_id IS 'tb_resultのID'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_base_code IS '拠点CD'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_accept_date IS '受付日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_customer_code IS '統合顧客CD'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_customer_name IS '氏名'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_user_id IS '担当営業CD'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_user_name IS '担当営業氏名'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_user_base_code IS '担当営業所属拠点CD'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_car_name IS '車名'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_manage_number IS '統合車輌管理番号'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_start_date IS '作業開始日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_end_date IS '作業終了日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_detail IS '作業内容'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_hosyo_kbn IS '保証区分'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_youmei IS '用命事項'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_put_in_date IS '入庫日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_get_out_date IS '出庫日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_reserve_commit_date IS '予約承認日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_reserve_status IS '状況'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_work_put_date IS '作業進捗：入庫日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_delivered_date IS '作業進捗：納車済日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_syaken_next_date IS '次回車検日'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.rstc_web_reserv_flg IS 'Web予約'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_result_cars.updated_by IS '更新者'");

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
