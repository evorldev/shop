<?php

namespace App\Faker;


use Faker\Provider\Base;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImageProvider extends Base
{
    public function imageFromFixtures(string $sourceDirectory = 'images', string $targetDirectory = 'images'): string
    {
        try {
            $files = Storage::disk('fixtures')->allFiles($sourceDirectory);

            $from = $files[array_rand($files)];
            $extension = array_slice(explode('.', $from), -1)[0];

            $to = Str::of($targetDirectory)->finish('/') . Str::uuid() . '.' . $extension;

            Storage::disk('public')->put($to, Storage::disk('fixtures')->get($from));

            return Storage::disk('public')->url($to);
        } catch (Throwable $e) {
            return '';
        }
    }
}