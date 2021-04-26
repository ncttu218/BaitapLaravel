<?php

namespace App\Providers;

// use App\Models\Topics;
// use App\Models\Hansha;
// use App\Models\Car;
use App\Models\Base;
use App\Models\UserAccount;

use App\Original\Observer\ModelsObserver;
// use App\Original\Observer\TopicsModelObserver;
// use App\Original\Observer\HanshaModelObserver;
// use App\Original\Observer\CarModelObserver;
use App\Original\Observer\UserAccountModelObserver;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Eventサービスプロバイダー
 *
 */
class EventServiceProvider extends ServiceProvider {

    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'event.name' => [
            'EventListener',
        ],
        // ログイン完了イベント
        'App\Events\LoginedEvent' => [
            'App\Handlers\Events\LoginedHandler'
        ],
        // アップロード完了イベント
        'App\Events\UploadedEvent' => [
            'App\Handlers\Events\UploadedHandler'
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // 拠点用オブザーバー
        Base::observe( new ModelsObserver() );
        
        // トピックス用オブザーバー
        // Topics::observe( new TopicsModelObserver() );
                
        // 販社用オブザーバー
        // Hansha::observe( new HanshaModelObserver() );

        // 車種用オブザーバー
        // Car::observe( new CarModelObserver() );

        // ユーザーアカウント用オブザーバー
        UserAccount::observe( new UserAccountModelObserver() );

    }

}
