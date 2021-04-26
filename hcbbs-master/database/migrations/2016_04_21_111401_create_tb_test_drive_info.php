<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbTestDriveInfo extends Migration
{
	/**
	 * tb_test_drive_infoの作成コマンド
	 * インポートするデータ
	 * ・接触情報のうち試乗に関するデータ
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_test_drive_info');
		Schema::create('tb_test_drive_info', function (Blueprint $table) {
			$table->increments('id');
			$table->string('tdi_user_id')->nullable();
			$table->string('tdi_car_manage_number');
			$table->string('tdi_customer_code')->nullable();
			$table->date('tdi_contact_date')->nullable();
			$table->string('tdi_contact_ym')->nullable();
			$table->string('tdi_contact_number')->nullable();
			$table->string('tdi_contact_memo')->nullable();
			$table->string('tdi_way_code')->nullable();
			$table->string('tdi_yotei_number')->nullable();
			$table->string('tdi_result_code')->nullable();
			$table->string('tdi_result_name')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});

		DB::statement("COMMENT ON COLUMN tb_test_drive_info.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_contact_date IS '活動実績日'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_contact_ym IS '活動実績日の年月'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_contact_number IS '活動実績連番'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_contact_memo IS 'コメント記述'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_way_code IS '接触方法コード'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_yotei_number IS '接触予定連番'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_result_code IS '接触成果コード'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.tdi_result_name IS '接触成果名称'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_test_drive_info.updated_by IS '更新者'");
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
