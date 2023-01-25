<?php

namespace App\Providers;

use Carbon\CarbonInterval as Interval;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::preventLazyLoading(!app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

        DB::whenQueryingForLongerThan(500, function (Connection $connection, QueryExecuted $event) {
            logger()
                ->channel('telegram')
                ->debug('whenQueryingForLongerThan: ' . $connection->query()->toSql());
        });

        // $kernel = app(Kernel::class);
        $kernel = $this->app[Kernel::class];
        $kernel->whenRequestLifecycleIsLongerThan(
            Interval::second(4),
            function() {
                logger()
                    ->channel('telegram')
                    ->debug('whenRequestLifecycleIsLongerThan: ' . request()->url());
            }
        );
    }
}
