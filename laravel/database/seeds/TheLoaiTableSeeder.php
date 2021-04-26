<?php

use Illuminate\Database\Seeder;

class TheLoaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	DB::table('TheLoai')->insert([
        	['id' => '1','Ten' => 'Xã Hội','TenKhongDau' => 'Xa-Hoi'],
        	['id' => '2','Ten' => 'Thế Giới','TenKhongDau' => 'The-Gioi'],
        	['id' => '3','Ten' => 'Kinh Doanh','TenKhongDau' => 'Kinh-Doanh'],
        	['id' => '4','Ten' => 'Văn Hoá','TenKhongDau' => 'Van-Hoa'],
        	['id' => '5','Ten' => 'Thể Thao','TenKhongDau' => 'The-Thao'],
        	['id' => '6','Ten' => 'Pháp Luật','TenKhongDau' => 'Phap-Luat'],
        	['id' => '7','Ten' => 'Đời Sống','TenKhongDau' => 'Doi-Song'],
        	['id' => '8','Ten' => 'Khoa Học','TenKhongDau' => 'Khoa-Hoc'],
        	['id' => '9','Ten' => 'Vi Tính','TenKhongDau' => 'Vi-Tinh']
    	]);

    }
}
