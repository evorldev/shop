<?php

namespace Support\Testing;

use Faker\Provider\Base;
use Illuminate\Support\Facades\Log;
use Services\Images\Exceptions\FixturesException;
use Services\Images\FixturesApi;

class FakerImageProvider extends Base
{
    public function fixturesImage(
        string $sourceDirectory = '',
        string $targetDirectory = 'fixtures'
    ): ?string
    {
        try {
            return FixturesApi::copyImageFromFixtures($sourceDirectory, $targetDirectory);
        } catch (FixturesException $e) {
            Log::error($e->getMessage(), ['Exception' => $e->getPrevious()?->getMessage()]);

            return null;
        }
    }
}
