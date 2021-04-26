<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VTenkenMuryou6Result extends Migration {

	/**
	 * v_tenken_muryou6_resultの作成コマンド
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$sql = <<<EOT
CREATE OR REPLACE VIEW v_tenken_muryou6_result AS
 SELECT 1 AS rst_inspection_id,
    to_char(date_trunc('month'::text, tb_result.rst_syaken_next_date + '-2 years -6 mons'::interval)::date::timestamp with time zone, 'yyyymm'::text) AS rst_inspection_date,
	tb_result.id
	, tb_result.rst_base_code
	, tb_result.rst_accept_date
	, tb_result.rst_customer_code
	, tb_result.rst_customer_name
	, tb_result.rst_user_id
	, tb_result.rst_user_name
	, tb_result.rst_user_base_code
	, tb_result.rst_car_name
	, tb_result.rst_manage_number
	, tb_result.rst_start_date
	, tb_result.rst_end_date
	, tb_result.rst_detail
	, tb_result.rst_hosyo_kbn
	, tb_result.rst_youmei
	, tb_result.rst_put_in_date
	, tb_result.rst_get_out_date
	, tb_result.rst_reserve_commit_date
	, tb_result.rst_reserve_status
	, tb_result.rst_work_put_date
	, tb_result.rst_delivered_date
	, tb_result.rst_syaken_next_date
	, tb_result.rst_web_reserv_flg
   FROM tb_result
  WHERE tb_result.rst_syaken_next_date IS NOT NULL AND tb_result.rst_detail = '無６点検'::text;
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
		DB::statement('drop view v_tenken_muryou6_result');
	}

}
