<?php

declare(strict_types=1);

namespace App\Domain\Dto;

readonly class ProductOffer
{
    public function __construct(private mixed $offer) {}

    public function offer(): mixed
    {
        return $this->offer;
    }
}
