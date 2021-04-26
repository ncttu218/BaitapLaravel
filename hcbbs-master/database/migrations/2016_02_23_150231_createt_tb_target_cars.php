<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatetTbTargetCars extends Migration {

	/**
	 * tb_target_carsを作成するコマンド
	 * インポートするデータ
	 * ・v_syaken
	 * ・v_tenken_ansin_kaiteki
	 * ・v_tenken_houtei_12
	 * ・v_tenken_muryou6
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_target_cars');
		Schema::create('tb_target_cars', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('tgc_inspection_id');
			$table->string('tgc_inspection_ym');
			$table->integer('tgc_customer_id')->nullable();
			$table->string('tgc_car_manage_number');
			$table->string('tgc_base_code')->nullable();
			$table->string('tgc_base_name')->nullable();
			$table->string('tgc_user_id')->nullable();
			$table->string('tgc_user_name')->nullable();
			$table->string('tgc_customer_code')->nullable();
			$table->string('tgc_customer_name_kanji')->nullable();
			$table->string('tgc_gensen_code_name')->nullable();
			$table->string('tgc_customer_category_code_name')->nullable();
			$table->string('tgc_action_pattern_code')->nullable();
			$table->string('tgc_customer_postal_code')->nullable();
			$table->string('tgc_customer_address')->nullable();
			$table->string('tgc_customer_tel')->nullable();
			$table->string('tgc_customer_office_tel')->nullable();
			$table->string('tgc_car_name')->nullable();
			$table->string('tgc_car_year_type')->nullable();
			$table->string('tgc_first_regist_date_ym')->nullable();
			$table->date('tgc_cust_reg_date')->nullable();
			$table->string('tgc_car_base_number')->nullable();
			$table->string('tgc_car_maker_code')->nullable();
			$table->string('tgc_car_model')->nullable();
			$table->string('tgc_car_service_code')->nullable();
			$table->string('tgc_car_frame_number')->nullable();
			$table->string('tgc_car_type_code')->nullable();
			$table->string('tgc_car_buy_type')->nullable();
			$table->string('tgc_car_new_old_kbn_name')->nullable();
			$table->integer('tgc_syaken_times')->nullable()->default(0);
			$table->date('tgc_syaken_next_date')->nullable();
			$table->string('tgc_customer_insurance_type')->nullable();
			$table->string('tgc_customer_insurance_company')->nullable();
			$table->date('tgc_customer_insurance_end_date')->nullable();
			$table->string('tgc_customer_kouryaku_flg')->nullable();
			$table->string('tgc_customer_dm_flg')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
			$table->integer('dm_confirm_flg')->nullable()->default(0);
			$table->timestamp('confirm_date')->nullable();
			$table->string('confirmed_person')->nullable();
			$table->string('tgc_customer_name_kata')->nullable();
			$table->string('dm_unnecessary_reason')->nullable();
			$table->integer('tgc_mikomi_id')->nullable();
			$table->integer('tgc_is_mikomi')->nullable();
			$table->integer('tgc_last_other_company_flg')->nullable();
			$table->string('tgc_syaken_ikou')->nullable();
			$table->integer('tgc_status')->nullable();
			$table->integer('tgc_action')->nullable();
			$table->text('tgc_memo')->nullable();
		});
		DB::statement("COMMENT ON COLUMN tb_target_cars.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_inspection_id IS '車点検区分'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_inspection_ym IS '対象年月'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_id IS 'tb_customertのID'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_manage_number IS '統合車両管理ＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_base_name IS '拠点略称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_user_name IS '担当者氏名（漢字）'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_code IS '顧客コード'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_name_kanji IS '顧客漢字氏名'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_gensen_code_name IS '源泉コード名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_category_code_name IS '顧客分類コード名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_action_pattern_code IS '基本活動パターン名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_postal_code IS '自宅郵便番号'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_address IS '＊自宅住所'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_tel IS '＊自宅電話番号'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_office_tel IS '＊勤務先電話番号'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_name IS '車名（カナ）'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_year_type IS '年式'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_first_regist_date_ym IS '＊初度登録年月　YYYYMM'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_cust_reg_date IS '＊登録日　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_base_number IS '＊車両基本登録No'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_maker_code IS 'メーカーコード名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_model IS '型式'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_service_code IS 'サービス通称名'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_frame_number IS 'フレームＮＯ'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_type_code IS '車種コード名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_buy_type IS '自販他販区分名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_car_new_old_kbn_name IS '新中区分名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_syaken_times IS '車検回数'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_syaken_next_date IS '＊次回車検日　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_insurance_type IS '任意保険加入区分名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_insurance_company IS '任意保険会社コード名称'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_insurance_end_date IS '＊任意保険終期　YYYY/MM/DD'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_kouryaku_flg IS '攻略対象車'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_dm_flg IS 'Ｄ／Ｍ不要区分'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.updated_by IS '更新者'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.dm_confirm_flg IS 'DMチェックのフラグ'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.confirm_date IS 'DMチェックした日付'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.confirmed_person IS 'DMチェックした人'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_customer_name_kata IS '顧客名のカタカナ'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.dm_unnecessary_reason IS 'DM不要理由'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_mikomi_id IS '見込みデータID'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_is_mikomi IS '見込客かどうか'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_last_other_company_flg IS '前回他車検'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_syaken_ikou IS '車点検意向区分'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_status IS '意向結果'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_action IS '活動内容'");
		DB::statement("COMMENT ON COLUMN tb_target_cars.tgc_memo IS '備考'");
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
