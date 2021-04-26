<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;

/**
 * 本社用管理画面コントローラー
 *
 * @author M.ueki
 *
 */
class SiteController extends Controller
{
    public function getIndex()
    {
        return view('site.index');
    }
    
    public function getSr01()
    {
        return view('site.sr01');
    }
    
    public function getBlog01()
    {
        return view('site.blog01');
    }
}