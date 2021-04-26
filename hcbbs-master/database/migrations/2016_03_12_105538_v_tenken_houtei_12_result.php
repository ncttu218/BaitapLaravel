<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VTenkenHoutei12Result extends Migration {

	/**
	 * v_tenken_houtei_12_resultの作成コマンド
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$sql = <<<EOT
CREATE OR REPLACE VIEW v_tenken_houtei_12_result AS
 WITH tb_result_v12 AS (
         SELECT
			id
			, rst_base_code
			, rst_accept_date
			, rst_customer_code
			, rst_customer_name
			, rst_user_id
			, rst_user_name
			, rst_user_base_code
			, rst_car_name
			, rst_manage_number
			, rst_start_date
			, rst_end_date
			, rst_detail
			, rst_hosyo_kbn
			, rst_youmei
			, rst_put_in_date
			, rst_get_out_date
			, rst_reserve_commit_date
			, rst_reserve_status
			, rst_work_put_date
			, rst_delivered_date
			, rst_syaken_next_date
			, rst_web_reserv_flg,
            (EXISTS ( SELECT cus.syaken_times
                   FROM tb_customer cus
                  WHERE cus.car_manage_number = tb_result.rst_manage_number AND cus.syaken_next_date = tb_result.rst_syaken_next_date AND cus.syaken_times = 1)) AS cus_syaken_times
           FROM tb_result
          WHERE tb_result.rst_syaken_next_date IS NOT NULL AND (tb_result.rst_detail = '１２ヶ月点検'::text OR tb_result.rst_detail = '中１２ヶ月点検'::text)
        )
 SELECT 3 AS rst_inspection_id,
    to_char(regexp_split_to_table(array_to_string(ARRAY[
        CASE
            WHEN tb_result_v12.cus_syaken_times = true THEN date_trunc('month'::text, tb_result_v12.rst_syaken_next_date + '-2 years'::interval)::date
            ELSE NULL::date
        END, date_trunc('month'::text, tb_result_v12.rst_syaken_next_date + '-1 years'::interval)::date], ':'::text), ':'::text)::date::timestamp with time zone, 'yyyymm'::text) AS rst_inspection_date,
	tb_result_v12.id
	, tb_result_v12.rst_base_code
	, tb_result_v12.rst_accept_date
	, tb_result_v12.rst_customer_code
	, tb_result_v12.rst_customer_name
	, tb_result_v12.rst_user_id
	, tb_result_v12.rst_user_name
	, tb_result_v12.rst_user_base_code
	, tb_result_v12.rst_car_name
	, tb_result_v12.rst_manage_number
	, tb_result_v12.rst_start_date
	, tb_result_v12.rst_end_date
	, tb_result_v12.rst_detail
	, tb_result_v12.rst_hosyo_kbn
	, tb_result_v12.rst_youmei
	, tb_result_v12.rst_put_in_date
	, tb_result_v12.rst_get_out_date
	, tb_result_v12.rst_reserve_commit_date
	, tb_result_v12.rst_reserve_status
	, tb_result_v12.rst_work_put_date
	, tb_result_v12.rst_delivered_date
	, tb_result_v12.rst_syaken_next_date
	, tb_result_v12.rst_web_reserv_flg
   FROM tb_result_v12;
EOT;
		DB::statement($sql);

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		DB::statement('drop view v_tenken_houtei_12_result');
	}

}
