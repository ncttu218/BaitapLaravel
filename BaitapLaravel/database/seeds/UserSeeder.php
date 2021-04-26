<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert(
            [
            ['id' => '1', 'user' => 'NGUYEN A', 'username' => 'NA',
            'email' => 'NguyenA@gmail.com', 'address' => '123 塩見', 'password' => '123'],
            ['id' => '2', 'user' => 'NGUYEN B', 'username' => 'NB',
            'email' => 'NguyenB@gmail.com', 'address' => '456 塩見', 'password' => '456']
            ]);
    }
}
