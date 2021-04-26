<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TbMemo extends Migration {

	/**
	 * tb_memoの作成コマンド
	 * TOPのスケジュールで使うデータ
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::dropIfExists('tb_memo');
		Schema::create('tb_memo', function(Blueprint $table) {
			$table->increments('id');
			$table->string('memo_base_code', 2);
			$table->string('memo_user_id', 3);
			$table->string('memo_yotei');
			$table->string('memo_naiyou');
			$table->date('memo_contact_day')->nullable();
			$table->string('memo_contact_time')->nullable();
			$table->string('memo_status')->nullable()->nullable();
			$table->string('memo_action')->nullable()->nullable();
			$table->string('memo_memo')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
		});

		DB::statement("COMMENT ON COLUMN tb_memo.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_base_code IS '販売店コード'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_user_id IS '担当者コード'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_yotei IS '予定名'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_naiyou IS '予定内容'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_contact_day IS '連絡日'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_contact_time IS '連絡時間'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_status IS '活動ステータス'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_action IS '活動内容'");
		DB::statement("COMMENT ON COLUMN tb_memo.memo_memo IS '備考'");
		DB::statement("COMMENT ON COLUMN tb_memo.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_memo.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_memo.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_memo.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_memo.updated_by IS '更新者'");
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
