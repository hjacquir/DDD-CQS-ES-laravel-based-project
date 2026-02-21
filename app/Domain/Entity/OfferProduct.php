<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\State;

readonly class OfferProduct
{
    public function __construct(
      private int $id,
      private string $image,
      private string $sku,
      private State $state,
      private int $price,
      private string $name
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getImage(): string
    {
        return $this->image;
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

    public function getName(): string
    {
        return $this->name;
    }
}
