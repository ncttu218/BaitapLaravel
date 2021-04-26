<?php

namespace App\Providers;

use App\Lib\Util\DateUtil;
use App\Original\Util\ViewUtil;
use App\Original\Util\SessionUtil;
use App\Original\Codes\CheckAriCodes;
use App\Original\Codes\DispCodes;
use App\Original\Codes\MaruBatsuCodes;
use App\Original\Codes\RowNumCodes;
use App\Original\Codes\Topics\TopicsCategoryCodes;
use App\Original\Codes\Topics\ViewCodes;
use App\Original\Codes\Topics\CampaignCodes;
use App\Original\Codes\Topics\ViewCampaignCodes;
use App\Original\Codes\Car\BodyTypeCodes;
use App\Original\Codes\MailPostTypeCodes;
use App\Original\Codes\UrlTargetCodes;
use App\Models\Role;
use App\Models\Area;
use App\Models\Pref;
use App\Models\Hansha;
use App\Models\Car;
use Illuminate\Support\ServiceProvider;
use View;

/**
 * Viewに値を埋め込むサービスプロバイダー
 *
 * @author yhatsutori
 *
 */
class ViewComposerServiceProvider extends ServiceProvider {

    /**
     * サービスプロバイダーを定義する時のルールです
     *
     */
    public function boot()
    {
        // ログインユーザー情報の埋め込み
        View::composer( ['*'], 'App\Http\ViewComposers\LoginAccountComposer' );

        // Utilクラスを使う為の埋め込み
        View::composer( ['*'], 'App\Http\ViewComposers\UtilComposer' );

        // Codeクラスを使う為の埋め込み
        View::composer( ['*'], 'App\Http\ViewComposers\CodeComposer' );

        #########################
        ## 車種
        #########################
        
        // ボディタイプ
        View::composer('elements.shop.shop_select', function($view) {
            $view->select = ViewUtil::genSelectTag(
                SessionUtil::getShopList(),
                false // 空の値のフラグ
            );
        });
        
        // メール投稿の種類のタブ
        View::composer('elements.tag.mail_post_type_tabs', function($view) {
            $data = $view->getData();
            $view->selector = $data['selector'] ?? null;
            $view->selected = $data['selected'] ?? null;
            $view->tabs = (new MailPostTypeCodes)->getOptions();
        });
        
        // メール投稿の種類の選択肢
        View::composer('elements.tag.mail_post_type_select', function($view) {
            $view->select = ViewUtil::genSelectTag(
                (new MailPostTypeCodes)->getOptions(),
                true // 空の値のフラグ
            );
        });
        
        // リンクの開き方の選択肢
        View::composer('elements.tag.url_target_select', function($view) {
            $view->select = ViewUtil::genSelectTag(
                (new UrlTargetCodes)->getOptions(),
                false // 空の値のフラグ
            );
        });
    
    }
    
    // 
    public function register(){}

}
