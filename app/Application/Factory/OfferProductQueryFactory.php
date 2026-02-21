<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Domain\Dto\OfferProductQuery;
use App\Domain\Entity\OfferProduct;

class OfferProductQueryFactory
{
    public function create(OfferProduct $offerProduct): OfferProductQuery
    {
        return new OfferProductQuery(
          $offerProduct->getId(),
          $offerProduct->getImage(),
          $offerProduct->getSku(),
          $offerProduct->getState(),
          $offerProduct->getPrice(),
          $offerProduct->getName(),
        );
    }
}
