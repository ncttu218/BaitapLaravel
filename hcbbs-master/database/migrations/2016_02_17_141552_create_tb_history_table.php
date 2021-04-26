<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbHistoryTable extends Migration {

	/**
	 * tb_historyを作成するコマンド
	 * インポートしたデータの詳細テーブル
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_history');
		Schema::create('tb_history', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('type_code');
			$table->integer('this_time_count')->defualt(0)->nullable();
			$table->integer('total_count')->defualt(0)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_history.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_history.type_code IS '種類コード'");
		DB::statement("COMMENT ON COLUMN tb_history.this_time_count IS 'データ件数（今回）'");
		DB::statement("COMMENT ON COLUMN tb_history.total_count IS '累計'");
		DB::statement("COMMENT ON COLUMN tb_history.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_history.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_history.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_history.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_history.updated_by IS '更新者'");

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
