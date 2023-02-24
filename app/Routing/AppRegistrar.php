<?php

namespace App\Routing;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ThumbnailsController;
use App\Routing\Contracts\RouteRegistrar;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Facades\Route;

class AppRegistrar implements RouteRegistrar
{
    public function map(Registrar $registrar): void
    {
        Route::middleware('web')->group(function() {
            Route::get('/', HomeController::class)->name('home');
        });

        Route::get('/images/' . config('thumbnails.directory', '.thumbnails') . '/{size}/{method}/{file}', ThumbnailsController::class)
            ->where('size', '\d+x\d+')
            ->where('method', 'resize|crop|fit')
            ->where('file', '.*\.([pP][nN][gG]|[jJ][pP][eE]?[gG])$') // it can include directories, it's ok
            ->name('thumbnail');
    }
}
