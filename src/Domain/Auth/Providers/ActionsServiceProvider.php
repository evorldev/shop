<?php

namespace Domain\Auth\Providers;

use Domain\Auth\Contracts\RegisterNewUserContract;
use Domain\Auth\Actions\RegisterNewUserAction;
use Illuminate\Support\ServiceProvider;

class ActionsServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RegisterNewUserContract::class => RegisterNewUserAction::class,
    ];
}
