<?php

namespace App\Providers;

use App\Models\User;
use App\Models\UsersServer;
use App\Policies\UserPolicy;
use App\Policies\UsersServerPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Server;
use App\Policies\ServerPolicy;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Server::class => ServerPolicy::class,
        User::class => UserPolicy::class,
        UsersServer::class => UsersServerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
