<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class FreshCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'shop:fresh';

    protected $description = 'Fresh DB with seed';

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return Command::FAILURE;
        }

        $this->deleteDirectories();

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

    private function deleteDirectories(): void
    {
        $directories = Storage::disk('public')->directories('images');

        if (empty($directories)) {
            $this->components->warn('Directories with images not found.');

            return;
        }

        $this->components->info('Deleting directories with images.');

        foreach ($directories as $directory) {
            $this->components->task($directory, function () use ($directory) {
                Storage::disk('public')->deleteDirectory($directory);
            });
        }

        $this->newLine();
    }
}
