<?php

namespace Services\Thumbnails;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterventionImage;
use Services\Thumbnails\Exceptions\ThumbnailsException;
use Throwable;

class ThumbnailsApi
{
    const IMAGES_DISK = 'images';
    const FiXTURES_DISK = 'fixtures';

    const THUMBNAILS_DIRECTORY = '.thumbnails';
    const THUMBNAILS_NAME_METHOD = 'ulid'; // ulid | uuid | orderedUuid | random

    const ALLOWED_SIZES = [];
    const ALLOWED_METHODS = ['resize', 'crop', 'fit'];

    /**
     * Сopies a random image from a 'source' directory on the _Fixtures_ disk
     * to a 'target' directory on the _Images_ disk.
     * Returns the path to a new file on the _Image_ disk. Or an empty srting.
     */
    public static function copyImageFromFixturesToImages(
        string $sourceDirectory = 'images',
        string $targetDirectory = 'fixtures'
    ): string
    {
        try {
            $imagesStorage = Storage::disk(self::IMAGES_DISK);
            $fixuresStorage = Storage::disk(self::FiXTURES_DISK);

            $source = Arr::random($fixuresStorage->allFiles($sourceDirectory));

            $target =
                $targetDirectory .
                '/' .
                Str::{self::THUMBNAILS_NAME_METHOD}() .
                '.' .
                File::extension($source);

            $imagesStorage->put($target, $fixuresStorage->get($source));

            return $target;
        } catch (Throwable $th) {
            throw new ThumbnailsException('Failed to copy a fixtures image.', 404, $th);
        }
    }

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
            if ($file != '.gitignore') {
                $storage->delete($file);
            }
        }
    }

    public static function getThumbnail(
        string $file,
        string $size,
        string $method
    ): InterventionImage
    {
        try {
            abort_unless(self::isSizeValid($size), 400, 'Size not allowed.');
            abort_unless(self::isMethodValid($method), 400, 'Method not allowed.');

            $thumbnail =
                config('thumbnails.directory', self::THUMBNAILS_DIRECTORY) .
                "/$size/$method/$file";

            $storage = Storage::disk(self::IMAGES_DISK);
            $filePath = $storage->path($file);
            $thumbnailPath = $storage->path($thumbnail);

            abort_unless(File::exists($filePath), 400, 'File not found.');

            if (File::exists($thumbnailPath)) {
                Log::warning('The existing thumbnail must be returned by the server as a static file. Check symbolic links.');

                return Image::make($thumbnailPath); // checks if the existing file is an image
            } else {
                File::ensureDirectoryExists(File::dirname($thumbnailPath));
            }

            return self::makeThumbnail($filePath, $thumbnailPath, $size, $method);
        } catch (Throwable $th) {
            throw new ThumbnailsException('Thumbnail not found.', 404, $th);
        }
    }

    private static function isSizeValid(string $size): bool
    {
        //TODO: check w and h
        return in_array($size, config('thumbnails.sizes', self::ALLOWED_SIZES));
    }

    private static function isMethodValid(string $method): bool
    {
        return in_array($method, self::ALLOWED_METHODS);
    }

    private static function makeThumbnail(
        string $filePath,
        string $thumbnailPath,
        string $size,
        string $method
    ): InterventionImage
    {
        [$w, $h] = explode('x', $size);

        $image = Image::make($filePath);
        $image->{$method}($w, $h);


        //TODO: add watermark
        // $file = resource_path('images/watermark.png');
        // $watermark = Image::make($file);
        // $image->insert($watermark, 'center');


        $image->save($thumbnailPath);

        return $image;
    }
}
