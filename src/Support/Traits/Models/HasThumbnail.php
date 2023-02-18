<?php

namespace Support\Traits\Models;

trait HasThumbnail
{
    public function thumbnailUrl(string $size, string $method = 'resize'): string
    {
        if (! $size ||
            ! $method ||
            ! $this->{$this->imageColumn()}) {
            return '';
        }

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
