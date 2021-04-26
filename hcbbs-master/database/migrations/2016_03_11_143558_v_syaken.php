<?php

use Illuminate\Database\Migrations\Migration;

class VSyaken extends Migration {

	/**
	 * v_syakenの作成コマンド
	 *
	 * @return void
	 */
	public function up()
	{
		$sql = <<<EOT
				CREATE OR REPLACE VIEW v_syaken AS
					SELECT tb_customer.id, tb_customer.car_manage_number,
					4 AS inspection_id,
					to_char(date_trunc('month'::text, tb_customer.syaken_next_date::timestamp with time zone)::date::timestamp with time zone, 'yyyymm'::text) AS inspection_date,
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
	}

}
