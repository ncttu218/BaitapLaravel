<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbBaseTable extends Migration {

	/**
	 * tb_baseを作成するコマンド
	 * 拠点に関するデータ
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_base');
		Schema::create('tb_base', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('base_code', 2);
			$table->string('base_name');
			$table->string('base_short_name');
			$table->integer('work_level')->default(0)->nullable();
			$table->integer('block_base_code')->defualt(0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_base.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_base.base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_base.base_name IS '拠点名'");
		DB::statement("COMMENT ON COLUMN tb_base.base_short_name IS '拠点略称'");
		DB::statement("COMMENT ON COLUMN tb_base.work_level IS '階層レベル 1は新車拠点,2は中古車拠点'");
		DB::statement("COMMENT ON COLUMN tb_base.block_base_code IS 'ブロック名'");
		DB::statement("COMMENT ON COLUMN tb_base.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_base.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_base.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_base.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_base.updated_by IS '更新者'");
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
