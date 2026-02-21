<?php

declare(strict_types=1);

namespace App\Domain\Dto;

use App\Domain\State;

class OfferQuery
{
    private string $name = '';
    private string $image = '';
    private string $slug = '';
    private ?State $state = null;
    private ?string $description = null;
    private array $products = [];

    public function __construct(private readonly int $id) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $name): OfferQuery
    {
        $this->name = $name;

        return $this;
    }

    public function image(): string
    {
        return $this->image;
    }

    public function setImage(string $image): OfferQuery
    {
        $this->image = $image;

        return $this;
    }

    public function slug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): OfferQuery
    {
        $this->slug = $slug;

        return $this;
    }

    public function state(): State
    {
        return $this->state;
    }

    public function setState(State $state): OfferQuery
    {
        $this->state = $state;

        return $this;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): OfferQuery
    {
        $this->description = $description;

        return $this;
    }

    public function products(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): OfferQuery
    {
        $this->products = $products;

        return $this;
    }

    public function id(): int
    {
        return $this->id;
    }
}
