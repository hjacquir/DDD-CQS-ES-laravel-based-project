<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Factory\OfferProductQueryFactory;
use App\Domain\Dto\OfferQuery;
use App\Domain\Repository\OfferRepositoryInterface;

readonly class OfferQueryHandler
{
    public function __construct(
      private OfferRepositoryInterface $offerRepository,
      private OfferProductQueryFactory $offerProductQueryFactory
    ) {}

    public function handle(OfferQuery $offerUiDto): void
    {
        $offer = $this->offerRepository->find($offerUiDto->id());

        $offerProductUiDto = [];

        foreach ($offer->getProducts() as $product) {
            $offerProductUiDto[] = $this->offerProductQueryFactory->create($product);
        }

        $offerUiDto
          ->setName($offer->getName())
          ->setProducts($offerProductUiDto)
          ->setDescription($offer->getDescription())
          ->setSlug($offer->getSlug())
          ->setState($offer->getState())
          ->setImage($offer->getImage())
        ;
    }
}
