<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Services\Thumbnails\ThumbnailsApi;

class FreshCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'app:fresh';

    protected $description = 'Clean the images disk, Fresh the database, Seed the database';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return Command::FAILURE;
        }

        $this->newLine();

        $this->components->task('Cleaning images directory', function () {
            ThumbnailsApi::cleanImagesDisk();
        });

        $this->components->task('Cleaning cache', function () {
            Cache::forget('brands_homepage');
            Cache::forget('categories_homepage');
        });

        Artisan::call(
            'migrate:fresh',
            [
                '--force' => true,
                '--seed' => true,
            ],
            $this->output
        );

        return Command::SUCCESS;
    }
}
