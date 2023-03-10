<?php

namespace Services\Images;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Lottery;
use Intervention\Image\Facades\Image;
use Intervention\Image\Image as InterventionImage;
use Services\Images\Exceptions\ThumbnailsException;
use Throwable;

class ThumbnailsApi
{
    const IMAGES_DISK = 'images';

    const DIRECTORY = '.thumbnails';

    const ALLOWED_SIZES = [];
    const ALLOWED_METHODS = ['resize', 'crop', 'fit'];

    private static function isSizeValid(string $size): bool
    {
        //TODO: check w and h
        return in_array($size, config('thumbnails.sizes', self::ALLOWED_SIZES));
    }

    private static function isMethodValid(string $method): bool
    {
        return in_array($method, self::ALLOWED_METHODS);
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
                config('thumbnails.directory', self::DIRECTORY) .
                "/$size/$method/$file";

            $storage = Storage::disk(self::IMAGES_DISK);
            $filePath = $storage->path($file);
            $thumbnailPath = $storage->path($thumbnail);

            abort_unless(File::exists($filePath), 400, 'File not found.');

            if (File::exists($thumbnailPath)) {
                Lottery::odds(1, 100)
                    ->winner(function() {
                        Log::warning('The existing thumbnail must be returned by the server as a static file. Check symbolic links.');
                    })
                    ->choose();

                return Image::make($thumbnailPath); // checks if the existing file is an image
            } else {
                File::ensureDirectoryExists(File::dirname($thumbnailPath));
            }

            return self::makeThumbnail($filePath, $thumbnailPath, $size, $method);
        } catch (Throwable $th) {
            throw new ThumbnailsException('Thumbnail not found.', 404, $th);
        }
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
