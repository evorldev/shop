<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Services\Thumbnails\ThumbnailsApi;

class ThumbnailsController extends Controller
{
    public function __invoke(string $size, string $method, string $file): Response
    {
        return ThumbnailsApi::getThumbnail($file, $size, $method)
            ->response();
    }
}
