<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbInfoTable extends Migration {

	/**
	 * tb_infoを作成するコマンド
	 * 本社管理のお知らせに関するデータ
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_info');
		Schema::create('tb_info', function(Blueprint $table)
		{
			$table->increments('id');
			$table->date('info_target_date');
			$table->string('info_base_code')->nullable();
			$table->string('info_user_id')->nullable();
			$table->integer('info_view_flg')->default(0)->nullable();
			$table->date('info_view_date_min')->nullable();
			$table->date('info_view_date_max')->nullable();
			$table->string('info_title');
			$table->text('info_body');
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});
		DB::statement("COMMENT ON COLUMN tb_info.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_info.info_target_date IS '対象日'");
		DB::statement("COMMENT ON COLUMN tb_info.info_base_code IS '拠点'");
		DB::statement("COMMENT ON COLUMN tb_info.info_user_id IS '記載者'");
		DB::statement("COMMENT ON COLUMN tb_info.info_view_flg IS '表示フラグ'");
		DB::statement("COMMENT ON COLUMN tb_info.info_view_date_min IS '掲載期間開始'");
		DB::statement("COMMENT ON COLUMN tb_info.info_view_date_max IS '掲載期間終了'");
		DB::statement("COMMENT ON COLUMN tb_info.info_title IS 'タイトル'");
		DB::statement("COMMENT ON COLUMN tb_info.info_body IS '内容'");
		DB::statement("COMMENT ON COLUMN tb_info.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_info.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_info.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_info.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_info.updated_by IS '更新者'");
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
