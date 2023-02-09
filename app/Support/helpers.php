<?php

use App\Support\Flash\Flash;

if (! function_exists('flash')) {
    function flash(string $message = null)
    {
        if (is_null($message)) {
            return app(Flash::class);
        }

        return app(Flash::class)->info($message);
    }
}
