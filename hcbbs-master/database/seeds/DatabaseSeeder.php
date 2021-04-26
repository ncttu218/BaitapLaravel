<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Models\Role;
use App\Models\UserAccount;
use App\Models\Base;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// DBにサンプルデータを挿入
		$this->call('RoleTableSeeder');
		$this->call('BaseTableSeeder');
		$this->call('UserTableSeeder');

        Model::reguard();
	}

}

/**
 * 権限のサンプルデータを挿入
 */
class RoleTableSeeder extends Seeder {
	public function run()
	{
        DB::table('roles')->delete();
        Role::create(
        	array(
        		'id' => 1
        		, 'role_code' => 'admin'
						, 'role_name' => '管理者'
						, 'priority' => '1'
						, 'created_by' => 1
						, 'updated_by' => 1
					)
				);
				Role::create(
					array(
        		'id' => 2
        		, 'role_code' => 'manager'
						, 'role_name' => '部長'
						, 'priority' => '2'
						, 'created_by' => 1
						, 'updated_by' => 1
					)
				);
				Role::create(
					array(
        		'id' => 3
        		, 'role_code' => 'head_staff'
						, 'role_name' => '本社'
						, 'priority' => '3'
						, 'created_by' => 1
						, 'updated_by' => 1
					)
				);
				Role::create(
					array(
        		'id' => 4
        		, 'role_code' => 'store_manager'
						, 'role_name' => '店長'
						, 'priority' => '4'
						, 'created_by' => 1
						, 'updated_by' => 1
					)
				);
				Role::create(
					array(
        		'id' => 6
        		, 'role_code' => 'factory_manager'
						, 'role_name' => '工場長'
						, 'priority' => '5'
						, 'created_by' => 1
						, 'updated_by' => 1
					)
				);
				Role::create(
					array(
        		'id' => 5
        		, 'role_code' => 'sales'
						, 'role_name' => '営業担当'
						, 'priority' => '6'
						, 'created_by' => 1
						, 'updated_by' => 1
					)
				);
    }
}

/**
 * 拠点のサンプルデータを挿入
 */
class BaseTableSeeder extends Seeder {
	public function run()
	{
        DB::table('tb_base')->delete();
        Base::create(
        	array(
        		'base_code' => '01'
				, 'base_name' => '本社'
				, 'base_short_name' => '本社'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '03'
				, 'base_name' => '前橋問屋町店'
				, 'base_short_name' => '前橋問屋町'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '06'
				, 'base_name' => '東部バイパス店'
				, 'base_short_name' => '東部バイパス'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '07'
				, 'base_name' => '渋川有馬店'
				, 'base_short_name' => '渋川有馬'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '08'
				, 'base_name' => '高崎緑町店'
				, 'base_short_name' => '高崎緑町'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '09'
				, 'base_name' => '藤岡店'
				, 'base_short_name' => '藤岡'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '10'
				, 'base_name' => '高崎倉賀野店'
				, 'base_short_name' => '高崎倉賀野'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '11'
				, 'base_name' => '高崎下之城店'
				, 'base_short_name' => '高崎下之城'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '12'
				, 'base_name' => '沼田１２０号店'
				, 'base_short_name' => '沼田１２０号'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '13'
				, 'base_name' => '前橋箱田店'
				, 'base_short_name' => '前橋箱田'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '14'
				, 'base_name' => '高崎江木店'
				, 'base_short_name' => '高崎江木'
				, 'work_level' => 1
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);
        Base::create(
        	array(
        		'base_code' => '70'
				, 'base_name' => 'オートテラス前橋よしおか'
				, 'base_short_name' => 'AT前橋よしおか'
				, 'work_level' => 2
				, 'block_base_code' => 1
        		, 'created_by' => 1
        		, 'updated_by' => 1
			)
		);

	}
}

/**
 * 担当者のサンプルデータを挿入
 */
class UserTableSeeder extends Seeder {

	/*
	 * created_by, updated_byはUserAccountObserver経由で登録
	 */
	public function run()
	{
		//DB::table('tb_user_account')->delete();
		/** システム管理アカウントはシーダーを利用する */
        UserAccount::create([
			'user_id' => '999',
			'user_login_id' => '999',
			'password' => '12345',
            'user_password' => '12345',
			'user_name' => 'システム',
			'account_level' => 1,
			'base_code' => '01',
		]);
		/*UserAccount::create(
			array(
						'user_id' => '002'
						, 'user_login_id' => 'ot002'
						, 'password' => '12345'
						, 'user_name' => '部長 部太郎'
						, 'account_level' => 2
						, 'base_code' => '11'
						, 'bikou' => '備考'
			)
		);
		UserAccount::create(
			array(
						'user_id' => '003'
						, 'user_login_id' => 'ot003'
						, 'password' => '12345'
						, 'user_name' => '本社 本太郎'
						, 'account_level' => 3
						, 'base_code' => '12'
						, 'bikou' => '備考'
			)
		);
		UserAccount::create(
			array(
						'user_id' => '004'
						, 'user_login_id' => 'ot004'
						, 'password' => '12345'
						, 'user_name' => '拠点長 店太郎'
						, 'account_level' => 4
						, 'base_code' => '13'
						, 'bikou' => '備考'
			)
		);
		UserAccount::create(
			array(
						'user_id' => '005'
						, 'user_login_id' => 'ot005'
						, 'password' => '12345'
						, 'user_name' => '工場長 工太郎'
						, 'account_level' => 5
						, 'base_code' => '14'
						, 'bikou' => '備考'
			)
		);
		UserAccount::create(
			array(
						'user_id' => '006'
						, 'user_login_id' => 'ot006'
						, 'password' => '12345'
						, 'user_name' => '営業 営太郎'
						, 'account_level' => 6
						, 'base_code' => '70'
						, 'bikou' => '備考'
			)
		);*/
	}
}
