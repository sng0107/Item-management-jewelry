<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            //利用者権限のアカウントには表示させないメニューの設定
            if (auth()->user()->role == 0){
                $event->menu->remove('商品登録_role1_only');
                $event->menu->remove('仕入管理_role1_only');
                $event->menu->remove('仕入履歴_role1_only');
                $event->menu->remove('仕入登録_role1_only');
                $event->menu->remove('コスト管理_role1_only');
                $event->menu->remove('　　コスト一覧_role1_only');
                $event->menu->remove('カテゴリー管理_role1_only');
                $event->menu->remove('　　アイテム_role1_only');
                $event->menu->remove('　　仕入先_role1_only');
                $event->menu->remove('アカウント管理_role1_only');
                $event->menu->remove('アカウント_role1_only');
                
                
            };
        });
    
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
