<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class LikeController extends Controller
{
    protected $hansha_code;
    protected $num;
    protected $ip;

    public function __construct(Request $request)
    {
        $this->hansha_code = $request->get('hansha_code');
        $this->num = $request->get('num');
        $this->ip = $request->get('ip');
    }

    // likeの登録
    public function addLike()
    {
        $table_name = 'tb_' . $this->hansha_code . '_infobbs_comment';
        $time_now = Carbon::now()->toDateString();

        if (!Schema::hasTable($table_name)){
            return;
        }

        $exits = DB::table('tb_' . $this->hansha_code . '_infobbs_comment')
            ->where('num', '=', $this->num)
            ->where('ip', '=', $this->ip)
            ->exists();
        if ($exits) {
            return response()->json(['message' => 'すでにいいねしています。', 'add_like' => false], 200);
        } else {
            DB::table('tb_' . $this->hansha_code . '_infobbs_comment')
                ->insert([
                    'num' => $this->num,
                    'mark'=>'GJ',
                    'created_at'=>$time_now,
                    'ip' => $this->ip,
                ]);
            $count = DB::table('tb_' . $this->hansha_code . '_infobbs_comment')
                ->where('num', $this->num)
                ->get()
                ->count();
            return response()->json([
                'message' => 'successfully',
                'count' => $count,
                'add_like' => true
            ], 200
            );
        }

    }

    //　Countのデータの取得
    public function getCount()
    {
        $count = 0;
        if ($this->hansha_code == '' || $this->num == '') {
            return $count;
        }
        $count = DB::table('tb_' . $this->hansha_code . '_infobbs_comment')
            ->where('num', $this->num)
            ->get()
            ->count();
        return $count;
    }
}
