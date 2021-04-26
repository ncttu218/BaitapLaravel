<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration {

	/**
	 * rolesを作成するコマンド
	 * このシステムを利用するユーザーの権限に関するデータ
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::dropIfExists('roles');
		Schema::create('roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('role_code')->unique();
			$table->string('role_name');
			$table->integer('priority');
			$table->timestamps();
			$table->softDeletes()->nullable();
			$table->integer('created_by');
			$table->integer('updated_by');
		});

		DB::statement("COMMENT ON COLUMN roles.id IS 'シリアルID'");
		DB::statement("COMMENT ON COLUMN roles.role_code IS 'ロールコード'");
		DB::statement("COMMENT ON COLUMN roles.role_name IS 'ロール名'");
		DB::statement("COMMENT ON COLUMN roles.priority IS '優先度（小さいほうが上)'");
		DB::statement("COMMENT ON COLUMN roles.created_at IS '登録日時'");
		DB::statement("COMMENT ON COLUMN roles.updated_at IS '更新日時'");
		DB::statement("COMMENT ON COLUMN roles.deleted_at IS '削除日時'");
		DB::statement("COMMENT ON COLUMN roles.created_by IS '登録者'");
		DB::statement("COMMENT ON COLUMN roles.updated_by IS '更新者'");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('roles');
	}

}
