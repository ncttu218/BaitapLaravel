<?php

use Illuminate\Database\Migrations\Migration;

class VTenkenMuryou6 extends Migration {

	/**
	 * v_tenken_muryou6の作成コマンド
	 *
	 * @return void
	 */
	public function up()
	{
		//
		$sql = <<<EOT
				CREATE OR REPLACE VIEW v_tenken_muryou6 AS
					SELECT tb_customer.id, tb_customer.car_manage_number,
					1 AS inspection_id,
					to_char(date_trunc('month'::text, tb_customer.syaken_next_date + '-2 years -6 mons'::interval)::date::timestamp with time zone, 'yyyymm'::text) AS inspection_date,
					tb_customer.syaken_next_date, tb_customer.syaken_times,
					tb_customer.base_code,
					tb_customer.customer_code, tb_customer.customer_name_kanji,
					tb_customer.car_maker_code
				FROM tb_customer
				WHERE tb_customer.syaken_next_date IS NOT NULL AND tb_customer.syaken_times = 1;
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
	}

}
