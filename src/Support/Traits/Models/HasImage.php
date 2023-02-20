<?php

namespace Support\Traits\Models;

trait HasImage
{
    protected function imageColumn(): string
    {
        return 'image';
    }

    public function imagePath(): string
    {
        return $this->{$this->imageColumn()};
    }

    // public function thumbnailUrl(string $size, string $method = 'resize'): string
    // {
    //     if (! $size ||
    //         ! $method ||
    //         ! $this->imagePath()) {
    //         return '';
    //     }

    //     return route('thumbnail', [
    //         'size' => $size,
    //         'method' => $method,
    //         'file' => $this->imagePath(),
    //     ]);
    // }
}
