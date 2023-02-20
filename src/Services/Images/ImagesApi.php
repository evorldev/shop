<?php

namespace Services\Images;

use Illuminate\Support\Facades\Storage;

class ImagesApi
{
    const IMAGES_DISK = 'images';

    public static function cleanImagesDisk()
    {
        // File::cleanDirectory(Storage::disk(self::IMAGES_DISK)->path()); // .gitignore is also deleted

        $storage = Storage::disk(self::IMAGES_DISK);

        $directories = $storage->directories();
        foreach ($directories as $directory) {
            $storage->deleteDirectory($directory);
        }

        $files = $storage->files();
        foreach ($files as $file) {
            if ('.gitignore' != $file) {
                $storage->delete($file);
            }
        }
    }
}
