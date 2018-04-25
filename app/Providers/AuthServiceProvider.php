<?php

namespace App\Providers;

use Laravel\Passport\Passport;
// use Illuminate\Support\Facades\Auth;
// use App\Extensions\MerryUserProvider;
// use App\Extensions\CustomUserRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // app()->bind(\Laravel\Passport\Bridge\UserRepository::class, CustomUserRepository::class);

        Passport::routes();

        Passport::tokensCan([
            'profile' => 'Access your profile information',
            'private' => 'Access your private life',
        ]);

        // Auth::provider('merry_provider', function ($app, array $config) {
        //     return new MerryUserProvider();
        // });
    }
}
