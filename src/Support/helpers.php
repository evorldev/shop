<?php

use Domain\Catalog\Filters\FilterManager;
use Support\Flash\Flash;

if (! function_exists('flash')) {
    function flash(string $message = null)
    {
        if (is_null($message)) {
            return app(Flash::class);
        }

        return app(Flash::class)->info($message);
    }
}

if (! function_exists('thumbnail')) {
    function thumbnail(string $file, string $size, string $method = 'resize')
    {
        return route('thumbnail', [
            'size' => $size,
            'method' => $method,
            'file' => $file,
        ]);
    }
}

if (! function_exists('filters')) {
    function filters(): array
    {
        return app(FilterManager::class)->items();
    }
}
