<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbContact extends Migration {

	/**
	 * tb_contactを作成するコマンド
	 * インポートするデータ
	 * ・活動日報実績.csv
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_contact');
		Schema::create('tb_contact', function( Blueprint $table ) {
			$table->increments('id');
			$table->string('ctc_user_id')->nullable();
			$table->string('ctc_customer_code')->nullable();
			$table->date('ctc_contact_date')->nullable();
			$table->string('ctc_contact_ym')->nullable();
			$table->string('ctc_contact_number')->nullable();
			$table->string('ctc_contact_memo')->nullable();
			$table->string('ctc_way_code')->nullable();
			$table->string('ctc_yotei_number')->nullable();
			$table->string('ctc_result_code')->nullable();
			$table->string('ctc_result_name')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
			$table->string('ctc_car_manage_number');
		});

		DB::statement("COMMENT ON COLUMN tb_contact.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_contact_date IS '活動実績日'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_contact_ym IS '活動実績日の年月'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_contact_number IS '活動実績連番'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_contact_memo IS 'コメント記述'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_way_code IS '接触方法コード'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_yotei_number IS '接触予定連番'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_result_code IS '接触成果コード'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_result_name IS '接触成果名称'");
		DB::statement("COMMENT ON COLUMN tb_contact.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_contact.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_contact.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_contact.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_contact.updated_by IS '更新者'");
		DB::statement("COMMENT ON COLUMN tb_contact.ctc_car_manage_number IS '統合車両管理No'");
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
