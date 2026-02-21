<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\State;

readonly class ProductCommand
{
    public function __construct(
      private string $name,
      private string $sku,
      private State $state,
      private int $price,
      private ProductOffer $productOffer,
      private ProductImage $productImage,
    ) {}

    public function name(): string
    {
        return $this->name;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function state(): State
    {
        return $this->state;
    }

    public function productOffer(): ProductOffer
    {
        return $this->productOffer;
    }

    public function productImage(): ProductImage
    {
        return $this->productImage;
    }
}
