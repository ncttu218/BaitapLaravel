<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbResultTable extends Migration {

	/**
	 * tb_resultを作成するコマンド
	 * インポートするデータ
	 * ・PIT管理作業明細.csv
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_result');
		Schema::create('tb_result', function(Blueprint $table) {
			$table->increments('id');
			$table->string('rst_base_code', 2)->nullable();
			$table->timestamp('rst_accept_date')->nullable();
			$table->string('rst_customer_code')->nullable();
			$table->string('rst_customer_name')->nullable();
			$table->string('rst_user_id', 3)->nullable();
			$table->string('rst_user_name')->nullable();
			$table->string('rst_user_base_code', 2)->nullable();
			$table->string('rst_car_name')->nullable();
			$table->string('rst_manage_number');
			$table->timestamp('rst_start_date')->nullable();
			$table->string('rst_end_date')->nullable();
			$table->string('rst_detail')->nullable();
			$table->string('rst_hosyo_kbn')->nullable();
			$table->string('rst_youmei')->nullable();
			$table->timestamp('rst_put_in_date')->nullable();
			$table->timestamp('rst_get_out_date')->nullable();
			$table->timestamp('rst_reserve_commit_date')->nullable();
			$table->string('rst_reserve_status')->nullable();
			$table->timestamp('rst_work_put_date')->nullable();
			$table->timestamp('rst_delivered_date')->nullable();
			$table->date('rst_syaken_next_date')->nullable();
			$table->string('rst_matagi_group_number')->nullable();
			$table->string('rst_web_reserv_flg')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_result.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_base_code IS '拠点CD'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_accept_date IS '受付日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_customer_code IS '統合顧客CD'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_customer_name IS '氏名'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_user_id IS '担当営業CD'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_user_name IS '担当営業氏名'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_user_base_code IS '担当営業所属拠点CD'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_car_name IS '車名'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_manage_number IS '統合車輌管理番号'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_start_date IS '作業開始日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_end_date IS '作業終了日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_detail IS '作業内容'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_hosyo_kbn IS '保証区分'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_youmei IS '用命事項'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_put_in_date IS '入庫日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_get_out_date IS '出庫日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_reserve_commit_date IS '予約承認日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_reserve_status IS '状況'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_work_put_date IS '作業進捗：入庫日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_delivered_date IS '作業進捗：納車済日時'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_syaken_next_date IS '次回車検日'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_matagi_group_number IS '日またぎ作業グループ番号'");
		DB::statement("COMMENT ON COLUMN tb_result.rst_web_reserv_flg IS 'Web予約'");
		DB::statement("COMMENT ON COLUMN tb_result.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_result.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_result.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_result.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_result.updated_by IS '更新者'");
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
