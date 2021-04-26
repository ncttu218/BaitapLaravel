<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Lib\Csv\Csv;

/**
 * CSVダウンロードを行う為のサービスプロバイダ
 */
class CSVServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton(
        	'csv',
        	function(){
        	    return new Csv;
        	}
        );
    }

}
