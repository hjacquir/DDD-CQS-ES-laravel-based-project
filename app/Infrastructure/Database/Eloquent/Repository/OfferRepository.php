<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Eloquent\Repository;

use App\Domain\Entity\Offer as OfferEntity;
use App\Domain\Entity\OfferProduct;
use App\Domain\Repository\OfferRepositoryInterface;
use App\Domain\State;
use App\Infrastructure\Database\Eloquent\Models\Offer;
use App\Infrastructure\Database\Eloquent\Models\Product;

class OfferRepository implements OfferRepositoryInterface
{
    public function find(int $id): OfferEntity
    {
        $offer = Offer::with('products')->findOrFail($id);
        // @todo introduire une Collection au lieu d'un array
        $products = [];

        $offer->products()->each(function (Product $product) use (&$products) {
            $products[] = new OfferProduct(
              $product->id,
              $product->image,
              $product->sku,
              State::getInstance($product->state),
              $product->price,
              $product->name
            );
        });

        return new OfferEntity(
          $offer->id,
          $offer->name,
          $offer->image,
          $offer->slug,
          State::getInstance($offer->state),
          $offer->description,
          $products
        );
    }
}
