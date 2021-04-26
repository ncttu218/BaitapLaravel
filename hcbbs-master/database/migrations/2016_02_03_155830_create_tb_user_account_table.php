<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTbUserAccountTable extends Migration {

	/**
	 * tb_user_accountを作成するコマンド
	 * このシステムを利用するユーザーに関するデータ
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('tb_user_account');
		Schema::create('tb_user_account', function(Blueprint $table) {
			$table->increments('id');
			$table->string('user_id', 3)->unique();
			$table->string('user_login_id');
			$table->string('password', 60);
			$table->string('user_password', 60);
			$table->string('user_name')->nullable();
			$table->integer('account_level')->nullable()->defualt(0)->unsigned();
			$table->string('base_code', 2)->nullable();
			$table->string('bikou')->nullable();
			$table->rememberToken();
			$table->timestamp('last_logined')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('created_by');
			$table->string('updated_by');
			$table->string('file_name')->nullable();
            $table->text('comment')->nullable();
            $table->integer('img_uploaded_flg')->nullable()->default(0);
            $table->timestamp('img_uploaded_at')->nullable();
		});

		DB::statement("COMMENT ON COLUMN tb_user_account.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN tb_user_account.user_id IS 'ユーザID'");
		DB::statement("COMMENT ON COLUMN tb_user_account.user_login_id IS 'ログインID'");
		DB::statement("COMMENT ON COLUMN tb_user_account.password IS 'パスワード'");
		DB::statement("COMMENT ON COLUMN tb_user_account.user_name IS 'ユーザー氏名'");
		DB::statement("COMMENT ON COLUMN tb_user_account.account_level IS 'アカウント権限'");
		DB::statement("COMMENT ON COLUMN tb_user_account.base_code IS '拠点コード'");
		DB::statement("COMMENT ON COLUMN tb_user_account.bikou IS '備考'");
		DB::statement("COMMENT ON COLUMN tb_user_account.remember_token IS 'トークン'");
		DB::statement("COMMENT ON COLUMN tb_user_account.last_logined IS '最終ログイン日時'");
		DB::statement("COMMENT ON COLUMN tb_user_account.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN tb_user_account.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN tb_user_account.deleted_at IS '削除フラグ'");
		DB::statement("COMMENT ON COLUMN tb_user_account.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN tb_user_account.updated_by IS '更新者'");
		DB::statement("COMMENT ON COLUMN tb_user_account.file_name IS '担当者の画像ファイル名'");
        DB::statement("COMMENT ON COLUMN tb_user_account.comment IS '担当者のコメント'");
        DB::statement("COMMENT ON COLUMN tb_user_account.img_uploaded_flg IS '画像がアップされたかのフラグ'");
        DB::statement("COMMENT ON COLUMN tb_user_account.img_uploaded_at IS '画像をアップした日付'");

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tb_user_account');
	}

}
