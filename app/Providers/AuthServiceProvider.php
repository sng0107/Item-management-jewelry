<?php

namespace App\Providers;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

         //利用者に許可  (記述がなくてもOK)
         Gate::define('利用者', function (User $user) {
            return ($user->role === 0 );
        });

        // 管理者のみ許可 (0=利用者/1=管理者)
        Gate::define('管理者', function (User $user) {
            return ($user->role === 1);
        });
    }
}
