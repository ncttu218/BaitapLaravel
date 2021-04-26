<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPlanSeiyaku extends Migration {

	/**
	 * tb_plan_seiyakuの作成コマンド
	 * ・本社管理の成約計画に関するデータ
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_plan_seiyaku');
		Schema::create('tb_plan_seiyaku', function(Blueprint $table) {
			$table->increments('id');
			$table->string('plan_base_code', 2)->nullable();
			$table->string('plan_user_id', 3)->nullable();
			$table->string('plan_year')->nullable();
			$table->string('plan_month')->nullable();
			$table->integer('plan_value')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});

		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.plan_base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.plan_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.plan_year IS '対象年'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.plan_month IS '対象月'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.plan_value IS '計画の値'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_plan_seiyaku.updated_by IS '更新者'");
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
