<?php

declare(strict_types=1);

namespace App\Domain\Dto;

readonly class ProductImage
{
    public function __construct(private mixed $image) {}

    public function image(): mixed
    {
        return $this->image;
    }
}
