<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {



        DB::table('Comment')->insert([
            ['id'=>'1','idUser' => '11','idTinTuc' => '1002','NoiDung' => 'Bài viết rất hay','created_at' => new DateTime()],
            ['id'=>'2','idUser' => '12','idTinTuc' => '1003','NoiDung' => 'Tôi rất thích bài viết này','created_at' => new DateTime()],
            ['id'=>'3','idUser' => '13','idTinTuc' => '1004','NoiDung' => 'Bài viết này tạm ổn','created_at' => new DateTime()],
            ['id'=>'4','idUser' => '14','idTinTuc' => '1005','NoiDung' => 'Hay quá trời','created_at' => new DateTime()],
            ['id'=>'5','idUser' => '15','idTinTuc' => '1006','NoiDung' => 'Tôi sẽ học thèo bài viết này','created_at' => new DateTime()],
            ['id'=>'6','idUser' => '16','idTinTuc' => '1007','NoiDung' => 'Bài viết này chưa được hay lắm','created_at' => new DateTime()],
            ['id'=>'7','idUser' => '17','idTinTuc' => '1008','NoiDung' => 'Ý kiến của tôi khác so với bài này','created_at' => new DateTime()],
            ['id'=>'8','idUser' => '18','idTinTuc' => '1009','NoiDung' => 'Bài viết này được','created_at' => new DateTime()],
            ['id'=>'9','idUser' => '19','idTinTuc' => '1010','NoiDung' => 'Không thích bài viết này','created_at' => new DateTime()],
            ['id'=>'10','idUser' => '110','idTinTuc' => '1011','NoiDung' => 'Tôi chưa có ý kiến gì','created_at' => new DateTime()],



        ]);
        //
    	/*$NoiDung = array(
    		'Bài viết rất hay',
    		'Tôi rất thích bài viết này',
    		'Bài viết này tạm ổn',
    		'Hay quá trời',
    		'Tôi sẽ học thèo bài viết này',
    		'Bài viết này chưa được hay lắm',
    		'Ý kiến của tôi khác so với bài này',
    		'Bài viết này được',
    		'Không thích bài viết này',
    		'Tôi chưa có ý kiến gì'
    	);

    	for($i=1;$i<=100;$i++)
    	{
	        DB::table('Comment')->insert(
	        	[
                    'id' => rand(1,10),
	        		'idUser' => rand(11,19),
	            	'idTinTuc' => rand(1000,2001),
	            	'NoiDung' => $NoiDung[rand(0,9)],
	            	'created_at' => new DateTime()
	        	]
	    	);
    	}*/
    }
}
