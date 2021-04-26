<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAbcTable extends Migration {

	/**
	 * tb_abcを作成するコマンド
	 * インポートするデータ
	 * ・ABCデータ.csv
	 * ※2016年8月16日現在使っていない
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_abc');
		Schema::create('tb_abc', function(Blueprint $table) {
			$table->increments('id');
			$table->string('abc_car_manage_number');
			$table->string('abc_abc')->nullable();
			$table->string('abc_insurance_type')->nullable();
			$table->string('abc_insurance_company')->nullable();
			$table->date('abc_insurance_end_date')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_abc.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_abc.abc_car_manage_number IS '統合車両管理ＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_abc.abc_abc IS 'ABCゾーン'");
		DB::statement("COMMENT ON COLUMN tb_abc.abc_insurance_type IS '任意保険加入区分名称'");
		DB::statement("COMMENT ON COLUMN tb_abc.abc_insurance_company IS '任意保険会社コード名称'");
		DB::statement("COMMENT ON COLUMN tb_abc.abc_insurance_end_date IS '＊任意保険終期　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_abc.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_abc.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_abc.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_abc.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_abc.updated_by IS '更新者'");

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
