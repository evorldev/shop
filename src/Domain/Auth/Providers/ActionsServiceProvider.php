<?php

namespace Domain\Auth\Providers;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Actions\RegisterNewUserAction;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class,
    ];
}
