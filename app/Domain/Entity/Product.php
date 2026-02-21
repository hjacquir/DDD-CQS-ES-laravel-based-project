<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Dto\ProductImage;
use App\Domain\Dto\ProductOffer;
use App\Domain\State;

readonly class Product
{
    public function __construct(
      private string $name,
      private string $sku,
      private State $state,
      private int $price,
      private ProductOffer $offer,
      private ProductImage $image
    ) {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getOffer(): ProductOffer
    {
        return $this->offer;
    }

    public function getImage(): ProductImage
    {
        return $this->image;
    }
}
