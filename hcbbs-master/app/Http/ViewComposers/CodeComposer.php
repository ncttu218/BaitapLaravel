<?php

namespace App\Http\ViewComposers;

use App\Original\Codes\DeleteCodes;
use App\Original\Codes\DispCodes;
use App\Original\Codes\MaruBatsuCodes;
use App\Original\Codes\RowNumCodes;

use Illuminate\Contracts\View\View;

/**
 * Codeクラスを使う為の
 * ビューコンポーサー用のクラス
 */
class CodeComposer
{
    
    /**
     * Codeクラスのオブジェクトを取得
     */
    public function __construct(){}

    public function compose( View $view ){        

        $view->with( 'DeleteCodes', new DeleteCodes() );
        $view->with( 'DispCodes', new DispCodes() );
        $view->with( 'MaruBatsuCodes', new MaruBatsuCodes() );
        $view->with( 'RowNumCodes', new RowNumCodes() );
        
    }

}