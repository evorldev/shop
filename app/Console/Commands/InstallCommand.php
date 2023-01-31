<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class InstallCommand extends Command
{
    protected $signature = 'shop:install';

    protected $description = 'Installation';


    public function handle(): int
    {
        $this->call('storage:link');
        $this->call('migrate');

        Storage::disk('public')->createDirectory('images/brands');
        Storage::disk('public')->createDirectory('images/products');

        return Command::SUCCESS;
    }
}
