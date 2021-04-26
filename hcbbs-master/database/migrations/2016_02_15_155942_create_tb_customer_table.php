<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbCustomerTable extends Migration {

	/**
	 * tb_customerを作成するコマンド
	 * インポートするデータ
	 * ・顧客データ.csv
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_customer');
		Schema::create('tb_customer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('car_manage_number');
			$table->string('base_code')->nullable();
			$table->string('base_name')->nullable();
			$table->string('user_id')->nullable();
			$table->string('user_name')->nullable();
			$table->string('customer_code')->nullable();
			$table->string('customer_name_kanji')->nullable();
			$table->string('customer_name_kata')->nullable();
			$table->string('gensen_code_name')->nullable();
			$table->string('customer_category_code_name')->nullable();
			$table->string('action_pattern_code')->nullable();
			$table->string('customer_postal_code')->nullable();
			$table->string('customer_address')->nullable();
			$table->string('customer_tel')->nullable();
			$table->string('customer_office_tel')->nullable();
			$table->string('car_name')->nullable();
			$table->string('car_year_type')->nullable();
			$table->string('first_regist_date_ym')->nullable();
			$table->date('cust_reg_date')->nullable();
			$table->string('car_base_number')->nullable();
			$table->string('car_maker_code')->nullable();
			$table->string('car_model')->nullable();
			$table->string('car_service_code')->nullable();
			$table->string('car_frame_number')->nullable();
			$table->string('car_type_code')->nullable();
			$table->string('car_buy_type')->nullable();
			$table->string('car_new_old_kbn_name')->nullable();
			$table->integer('syaken_times')->nullable()->default(0);
			$table->date('syaken_next_date')->nullable();
			$table->string('customer_insurance_type')->nullable();
			$table->string('customer_insurance_company')->nullable();
			$table->date('customer_insurance_end_date')->nullable();
			$table->string('customer_kouryaku_flg')->nullable();
			$table->string('customer_dm_flg')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});

		DB::statement("COMMENT ON COLUMN tb_customer.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_manage_number IS '統合車両管理ＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_customer.base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_customer.base_name IS '拠点略称'");
		DB::statement("COMMENT ON COLUMN tb_customer.user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_customer.user_name IS '担当者氏名（漢字）'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_name_kanji IS '顧客漢字氏名'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_name_kanji IS '顧客カナ氏名'");
		DB::statement("COMMENT ON COLUMN tb_customer.gensen_code_name IS '源泉コード名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_category_code_name IS '顧客分類コード名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.action_pattern_code IS '基本活動パターン名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_postal_code IS '自宅郵便番号'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_address IS '＊自宅住所'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_tel IS '＊自宅電話番号'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_office_tel IS '＊勤務先電話番号'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_name IS '車名（カナ）'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_year_type IS '年式'");
		DB::statement("COMMENT ON COLUMN tb_customer.first_regist_date_ym IS '＊初度登録年月　YYYYMM'");
		DB::statement("COMMENT ON COLUMN tb_customer.cust_reg_date IS '＊登録日　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_base_number IS '＊車両基本登録No'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_maker_code IS 'メーカーコード名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_model IS '型式'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_service_code IS 'サービス通称名'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_frame_number IS 'フレームＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_type_code IS '車種コード名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_buy_type IS '自販他販区分名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.car_new_old_kbn_name IS '新中区分名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.syaken_times IS '車検回数'");
		DB::statement("COMMENT ON COLUMN tb_customer.syaken_next_date IS '＊次回車検日　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_insurance_type IS '任意保険加入区分名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_insurance_company IS '任意保険会社コード名称'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_insurance_end_date IS '＊任意保険終期　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_kouryaku_flg IS '攻略対象車'");
		DB::statement("COMMENT ON COLUMN tb_customer.customer_dm_flg IS 'Ｄ／Ｍ不要区分'");
		DB::statement("COMMENT ON COLUMN tb_customer.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_customer.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_customer.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_customer.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_customer.updated_by IS '更新者'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_customer');
	}

}
