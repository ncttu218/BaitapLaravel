<?php

use Illuminate\Database\Migrations\Migration;

class VTenkenAnsinKaiteki extends Migration {

	/**
	 * v_tenken_ansin_kaitekiの作成コマンド
	 *
	 * @return void
	 */
	public function up()
	{
		$sql = <<<EOT
CREATE OR REPLACE VIEW v_tenken_ansin_kaiteki AS
 SELECT tb_customer.id, tb_customer.car_manage_number,
    2 AS inspection_id,
    to_char(regexp_split_to_table(array_to_string(ARRAY[date_trunc('month'::text, tb_customer.syaken_next_date + '-6 mons'::interval)::date, date_trunc('month'::text, tb_customer.syaken_next_date + '-1 years -6 mons'::interval)::date], ':'::text), ':'::text)::date::timestamp with time zone, 'yyyymm'::text) AS inspection_date,
    tb_customer.syaken_next_date, tb_customer.syaken_times,
    tb_customer.base_code,
    tb_customer.customer_code, tb_customer.customer_name_kanji,
    tb_customer.car_maker_code
   FROM tb_customer
  WHERE tb_customer.syaken_next_date IS NOT NULL;
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
		DB::statement('DROP VIEW v_tenken_ansin_kaiteki');
	}

}
