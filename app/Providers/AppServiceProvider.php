<?php

namespace App\Providers;

use Carbon\CarbonInterval as Interval;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Services\Telegram\TelegramBotApi;
use Services\Telegram\TelegramBotApiContract;

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
        // https://laravel.com/docs/9.x/eloquent#enabling-eloquent-strict-mode
        Model::shouldBeStrict(! $this->app->isProduction());


        //TODO:
        $this->app->bind(TelegramBotApiContract::class, TelegramBotApi::class);


        // https://laravel-news.com/laravel-9-31-0
        if ($this->app->runningInConsole()) {
            return;
        }

        $kernel = $this->app[Kernel::class];
        $kernel->whenRequestLifecycleIsLongerThan(
            Interval::second($threshold = 4),
            fn ($startedAt, $request, $response) =>
                Log::warning(
                    "Request lifecycle is longer than $threshold seconds.",
                    [
                        'url' => $request->url(),
                        'ip' => $request->ip(),
                        'user' => $request->user()?->id,
                    ]
                )
        );


        // // https://laravel.com/docs/9.x/database#monitoring-cumulative-query-time
        // DB::whenQueryingForLongerThan($threshold = 500, function (Connection $connection, QueryExecuted $event) use ($threshold) {
        //     Log::warning(
        //         "Querying for longer than $threshold millisecond.",
        //         [
        //         ]
        //     );
        // });


        // https://laravel.com/docs/9.x/database#listening-for-query-events
        DB::listen(
            function (QueryExecuted $query) {
                if ($query->time > $threshold = 100) {
                    Log::warning(
                        "Query execution time longer than $threshold millisecond.",
                        [
                            'time' => $query->time,
                            'sql' => $query->sql,
                            'bindings' => $query->bindings,
                        ]
                    );
                }
            }
        );
    }
}
