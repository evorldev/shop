<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Log;
use Services\Thumbnails\Exceptions\ThumbnailsException;
use Services\Thumbnails\ThumbnailsApi;

class FakerImageProvider extends Base
{
    public function fixturesImage(string $sourceDirectory = '', string $targetDirectory = ''): string
    {
        try {
            return ThumbnailsApi::copyImageFromFixturesToImages($sourceDirectory, $targetDirectory);
        } catch (ThumbnailsException $e) {
            Log::error($e->getMessage(), ['Exception' => $e->getPrevious()?->getMessage()]);

            return '';
        }
    }
}
