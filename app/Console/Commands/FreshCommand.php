<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Services\Images\ImagesApi;

class FreshCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'data:fresh';

    protected $description = 'Clean the images disk, Fresh the database, Seed the database';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return Command::FAILURE;
        }

        $this->newLine();

        $this->components->task('Clearing the cache', function () {
            Cache::flush();
        });

        $this->components->task('Cleaning the images disk', function () {
            ImagesApi::cleanImagesDisk();
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
