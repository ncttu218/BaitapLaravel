<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatetTbCiao extends Migration {

	/**
	 * tb_ciaoを作成するコマンド
	 * インポートするデータ
	 * ・チャオデータ.csv
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_ciao');
		Schema::create('tb_ciao', function(Blueprint $table) {
			$table->increments('id');
			$table->string('ciao_base_code', 2)->nullable();
			$table->string('ciao_base_name')->nullable();
			$table->string('ciao_user_id', 3)->nullable();
			$table->string('ciao_user_name')->nullable();
			$table->string('ciao_customer_code')->nullable();
			$table->string('ciao_customer_name')->nullable();
			$table->string('ciao_car_name')->nullable();
			$table->string('ciao_car_base_number_min')->nullable();
			$table->string('ciao_car_base_number')->nullable();
			$table->string('ciao_number')->nullable();
			$table->string('ciao_course')->nullable();
			$table->date('ciao_first_regist_date_ym')->nullable();
			$table->date('ciao_syaken_manryo_date')->nullable();
			$table->date('ciao_syaken_next_date')->nullable();
			$table->string('ciao_money')->nullable();
			$table->date('ciao_start_date')->nullable();
			$table->date('ciao_end_date')->nullable();
			$table->string('ciao_jisshi_type')->nullable();
			$table->string('ciao_jisshi_yotei')->nullable();
			$table->string('ciao_jisshi')->nullable();
			$table->string('ciao_jisshi_flg')->nullable();
			$table->string('ciao_course_keizoku')->nullable();
			$table->string('ciao_kaiinsyou_hakkou_date')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');

		});
		DB::statement("COMMENT ON COLUMN tb_ciao.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_base_name IS '拠点屋号名称'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_user_id IS '営業コード'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_user_name IS '担当営業'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_customer_name IS '顧客名'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_car_name IS '車名コード'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_car_base_number_min IS '＊車両基本登録No(番号のみ)'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_car_base_number IS '＊車両基本登録No'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_number IS '申込番号'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_course IS '加入コース'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_first_regist_date_ym IS '初度登録年月日'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_syaken_manryo_date IS '車検起算日'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_syaken_next_date IS '車検満了日'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_money IS '加入金額'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_start_date IS '会員証有効期間始期'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_end_date IS '会員証有効期間終期'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_jisshi_type IS '最終点検種別'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_jisshi_yotei IS '最終点検実施予定'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_jisshi IS '最終点検実施'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_jisshi_flg IS '実施フラグ'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_course_keizoku IS '継続加入継続加入コース'");
		DB::statement("COMMENT ON COLUMN tb_ciao.ciao_kaiinsyou_hakkou_date IS '継続加入会員証発行日'");
		DB::statement("COMMENT ON COLUMN tb_ciao.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_ciao.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_ciao.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_ciao.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_ciao.updated_by IS '更新者'");
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
