<?php

namespace Services\Images;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Services\Images\Exceptions\FixturesException;
use Throwable;

class FixturesApi
{
    const IMAGES_DISK = 'images';
    const FiXTURES_DISK = 'fixtures';

    const NAME_GENERATOR_METHOD = 'ulid'; // ulid | uuid | orderedUuid | random

    /**
     * Сopies a random image from a 'source' directory on the _Fixtures_ disk
     * to a 'target' directory on the _Images_ disk.
     * Returns the path to a new file on the _Image_ disk. Or throw FixturesException.
     */
    public static function copyImageFromFixtures(
        string $sourceDirectory,
        string $targetDirectory
    ): string
    {
        try {
            $imagesStorage = Storage::disk(self::IMAGES_DISK);
            $fixuresStorage = Storage::disk(self::FiXTURES_DISK);

            $sourcePath = self::getSourcePath($fixuresStorage, $sourceDirectory);

            $targetPath =
                $targetDirectory .
                '/' .
                Str::{self::NAME_GENERATOR_METHOD}() .
                '.' .
                File::extension($sourcePath);

            $imagesStorage->put($targetPath, $fixuresStorage->get($sourcePath));

            return $targetPath;
        } catch (Throwable $th) {
            throw new FixturesException('Failed to copy a fixtures image.', 404, $th);
        }
    }

    private static $fixturesFiles = [];

    private static function getSourcePath($fixuresStorage, string $sourceDirectory)
    {
        if (empty(self::$fixturesFiles[$sourceDirectory]['available'])) {
            if (empty(self::$fixturesFiles[$sourceDirectory]['all'])) {
                self::$fixturesFiles[$sourceDirectory]['all'] =
                    $fixuresStorage->allFiles($sourceDirectory);
            }

            self::$fixturesFiles[$sourceDirectory]['available'] =
                Arr::shuffle(self::$fixturesFiles[$sourceDirectory]['all']);
        }

        // return Arr::random(self::$fixturesFiles[$sourceDirectory]['all']);
        return array_pop(self::$fixturesFiles[$sourceDirectory]['available']);
    }
}
