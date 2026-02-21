<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Offer;

interface OfferRepositoryInterface
{
    public function find(int $id): Offer;
}
