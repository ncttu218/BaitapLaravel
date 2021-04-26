<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbMaintenance extends Migration {

	/**
	 * tb_maintenanceの作成コマンド
	 * インポートするデータ
	 * ・車点検接触管理情報.csv
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_maintenance');
		Schema::create('tb_maintenance', function(Blueprint $table) {
			$table->increments('id');
			$table->string('mt_base_code')->nullable();
			$table->string('mt_user_id')->nullable();
			$table->string('mt_customer_code')->nullable();
			$table->string('mt_customer_name')->nullable();
			$table->string('mt_car_manage_number')->nullable();
			$table->string('mt_car_name')->nullable();
			$table->date('mt_syaken_next_date')->nullable();
			$table->date('mt_syaken_ikou_date')->nullable();
			$table->string('mt_syaken_ikou')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});

		DB::statement("COMMENT ON COLUMN tb_maintenance.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_customer_name IS '顧客漢字氏名'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_car_manage_number IS '統合車両管理ＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_car_name IS 'サービス通称名'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_syaken_next_date IS '＊次回車検日　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_syaken_ikou_date IS '対象月'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.mt_syaken_ikou IS '車検意向区分(1=自社,2=他社)'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_maintenance.updated_by IS '更新者'");
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
