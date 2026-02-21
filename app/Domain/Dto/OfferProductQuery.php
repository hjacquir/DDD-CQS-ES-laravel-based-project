<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\State;

readonly class OfferProductQuery
{
    public function __construct(
      private int $id,
      private string $image,
      private string $sku,
      private State $state,
      private int $price,
      private string $name
    ) {}

    public function id(): int
    {
        return $this->id;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function state(): State
    {
        return $this->state;
    }

    public function price(): int
    {
        return $this->price;
    }

    public function name(): string
    {
        return $this->name;
    }
}
