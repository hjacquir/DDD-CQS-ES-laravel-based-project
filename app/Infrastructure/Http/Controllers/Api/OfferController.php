<?php

namespace App\Infrastructure\Http\Controllers\Api;

use App\Infrastructure\Database\Eloquent\Models\Offer;
use Illuminate\Http\JsonResponse;

// @todo ajouter authentification, cache, filter
class OfferController
{
    public function index(): JsonResponse
    {
        $offers = Offer::ofState('published')->with('products', fn ($q) => $q->where('state', 'published'))->get();

        return response()->json($offers);
    }
}
