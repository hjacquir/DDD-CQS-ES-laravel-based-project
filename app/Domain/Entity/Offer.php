<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\State;

readonly class Offer
{
    public function __construct(
      private int $id,
      private string $name,
      private string $image,
      private string $slug,
      private State $state,
      private ?string $description,
      // @todo introduire une Collection au lieu d'un array
      private array $products
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getState(): State
    {
        return $this->state;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @todo renvoyer une collection au lieu d'un array
     * @return \App\Domain\Entity\OfferProduct[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
