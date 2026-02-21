<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Domain\Dto\ProductCommand;
use App\Domain\Entity\Product;
use App\Domain\Repository\ProductRepositoryInterface;

readonly class ProductCommandHandler
{
    public function __construct(private ProductRepositoryInterface $productRepository) {}

    public function handle(ProductCommand $productCommand): void
    {
        // @todo validation specification domaine si besoin

        $product = new Product(
          $productCommand->name(),
          $productCommand->sku(),
          $productCommand->state(),
          $productCommand->price(),
          $productCommand->productOffer(),
          $productCommand->productImage()
        );

        $this->productRepository->save($product);
    }
}
