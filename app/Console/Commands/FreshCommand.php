<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class FreshCommand extends Command
{
    protected $signature = 'shop:fresh';

    protected $description = 'Fresh DB with seed';


    public function handle(): int
    {
        if (app()->isProduction()) {
            return Command::FAILURE;
        }

        Storage::disk('public')->deleteDirectory('images');
        Storage::disk('public')->createDirectory('images/brands');
        Storage::disk('public')->createDirectory('images/products');

        $this->call('migrate:fresh', [
            '--seed' => true,
        ]);

        return Command::SUCCESS;
    }
}
