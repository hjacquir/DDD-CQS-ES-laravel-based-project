<?php

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dto\ProductCommand;
use App\Domain\Dto\ProductImage;
use App\Domain\Dto\ProductOffer;
use App\Domain\State;
use App\Infrastructure\Database\Eloquent\Models\Offer;
use App\Infrastructure\Database\Eloquent\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;

class ProductController
{

    public function index(string $offerId): View
    {
        $offer = Offer::findOrFail($offerId);
        $products = $offer->products()->latest()->get();

        return view('products.index', compact('offer', 'products'));
    }

    public function create(string $offerId): View
    {
        $offer = Offer::findOrFail($offerId);
        $product = new Product();

        return view('products.create', compact('offer', 'product'));
    }

    public function store(Request $request, string $offerId): RedirectResponse
    {
        $offer = Offer::findOrFail($offerId);

        $data = $request->validate([
          'name' => ['required', 'string', 'max:255'],
          'sku' => ['required', 'string', 'max:255', 'unique:products,sku'],
          'image' => ['required', 'file'],
          'price' => ['required', 'numeric', 'min:0'],
          'state' => [
            'required',
            'in:'.implode(',', array_keys(Product::$states)),
          ],
        ]);

        Event::dispatch(
          new ProductCommand(
            $data['name'],
            $data['sku'],
            State::getInstance($data['state']),
            $data['price'],
            new ProductOffer($offer->id),
            new ProductImage($data['image'])
          )
        );

        return redirect()
          ->route('offers.products.index', $offer->id)
          ->with('status', 'Produit créé avec succès.');
    }

    public function edit(string $offerId, string $productId): View
    {
        $offer = Offer::findOrFail($offerId);
        $product = $offer->products()->findOrFail($productId);

        return view('products.edit', compact('offer', 'product'));
    }

    public function update(
      Request $request,
      string $offerId,
      string $productId
    ): RedirectResponse {
        $offer = Offer::findOrFail($offerId);
        $product = $offer->products()->findOrFail($productId);

        $data = $request->validate([
          'name' => ['required', 'string', 'max:255'],
          'sku' => [
            'required',
            'string',
            'max:255',
            'unique:products,sku,'.$product->id,
          ],
          'image' => ['nullable', 'file'],
          'price' => ['required', 'numeric', 'min:0'],
          'state' => [
            'required',
            'in:'.implode(',', array_keys(Product::$states)),
          ],
        ]);

        $product->update($data);

        if ($request->hasFile('image')) {
            $product->update(
              [
                'image' => $request->file('image')->store(
                  'products',
                  ['disk' => 'public']
                ),
              ]
            );
        }

        return redirect()
          ->route('offers.products.index', $offer->id)
          ->with('status', 'Produit mis à jour avec succès.');
    }

    public function destroy(
      string $offerId,
      string $productId
    ): RedirectResponse {
        $offer = Offer::findOrFail($offerId);
        $product = $offer->products()->findOrFail($productId);
        $product->delete();

        return redirect()
          ->route('offers.products.index', $offer->id)
          ->with('status', 'Produit supprimé avec succès.');
    }

}
