<?php

namespace Support\Traits\Models;

trait HasThumbnail
{
    public function makeThumbnail(string $size, string $method = 'resize'): string
    {
        return route('thumbnail', [
            'size' => $size,
            'method' => $method,
            'file' => $this->{$this->imageColumn()},
        ]);
    }

    protected function imageColumn(): string
    {
        return 'image';
    }
}
