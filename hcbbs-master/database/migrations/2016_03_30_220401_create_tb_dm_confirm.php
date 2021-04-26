<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbDmConfirm extends Migration {

	/**
	 * tb_dm_confirmの作成コマンド
	 * インポートするデータ
	 * ・dmのチェックを確認したかどうか
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_dm_confirm');
		Schema::create('tb_dm_confirm', function(Blueprint $table) {
			$table->increments('id');
			$table->string('user_id');
			$table->string('base_code');
			$table->string('inspection_ym');
			$table->timestamps();
			$table->softDeletes();
			$table->integer('dm_confirm_flg')->nullable()->default(0);
            $table->timestamp('confirm_date')->nullable();
            $table->string('confirmed_person')->nullable();
		});

		DB::statement("COMMENT ON COLUMN tb_dm_confirm.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_dm_confirm.base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_dm_confirm.user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_dm_confirm.inspection_ym IS '対象年月'");
		DB::statement("COMMENT ON COLUMN tb_dm_confirm.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_dm_confirm.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_dm_confirm.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.dm_confirm_flg IS 'DMチェックのフラグ'");
        DB::statement("COMMENT ON COLUMN tb_target_cars.confirm_date IS 'DMチェックした日付'");
        DB::statement("COMMENT ON COLUMN tb_target_cars.confirmed_person IS 'DMチェックした人'");
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
