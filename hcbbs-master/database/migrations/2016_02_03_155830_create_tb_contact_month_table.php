<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbContactMonthTable extends Migration {

	/**
	 * tb_contact_monthの作成コマンド
	 * インポートするデータ
	 * ・活動日報実績.csv
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_contact_month');
		Schema::create('tb_contact_month', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('cm_user_id')->nullable();
			$table->string('cm_customer_code')->nullable();
			$table->date('cm_contact_date')->nullable();
			$table->string('cm_contact_number')->nullable();
			$table->string('cm_contact_memo')->nullable();
			$table->string('cm_way_code')->nullable();
			$table->string('cm_yotei_number')->nullable();
			$table->string('cm_result_code')->nullable();
			$table->string('cm_result_name')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
			$table->string('cm_car_manage_number');
			$table->string('cm_contact_ym')->nullable();
		});

		DB::statement("COMMENT ON COLUMN tb_contact_month.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_contact_date IS '活動実績日'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_contact_number IS '活動実績連番'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_contact_memo IS 'コメント記述'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_way_code IS '接触方法コード'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_yotei_number IS '接触予定連番'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_result_code IS '接触成果コード'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_result_name IS '接触成果名称'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.updated_by IS '更新者'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_car_manage_number IS '統合車両管理No'");
		DB::statement("COMMENT ON COLUMN tb_contact_month.cm_contact_ym IS '活動次席日の年月'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('tb_user_account');
	}

}
