<?php

declare(strict_types=1);

namespace App\Infrastructure\Database\Eloquent\Repository;

use App\Domain\Entity\Product as ProductEntity;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\Database\Eloquent\Models\Product;
use App\Infrastructure\Exception\DatabaseException;

class ProductRepository implements ProductRepositoryInterface
{
    public function save(ProductEntity $product): void
    {
        $image = $product->getImage()->image();
        $offer = $product->getOffer()->offer();

        $data = [
          'name' => $product->getName(),
          'price' => $product->getPrice(),
          'offer_id' => $offer,
          'state' => $product->getState()->name,
          'sku' => $product->getSku(),
        ];

        try {
            $product = Product::create($data);
            $product->update(['image' => $image->store('products', ['disk' => 'public'])]);
        } catch (\Throwable $exception) {
            throw new DatabaseException($exception->getMessage());
        }
    }
}
