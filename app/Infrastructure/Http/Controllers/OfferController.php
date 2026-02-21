<?php

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Dto\OfferQuery;
use App\Infrastructure\Database\Eloquent\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class OfferController
{
    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
          'name' => ['required', 'string', 'max:255'],
          'slug' => ['required', 'string', 'max:255', 'unique:offers,slug'],
          'image' => ['required', 'image'],
          'description' => ['nullable', 'string', 'max:255'],
          'state' => ['required', 'string', 'in:draft,published,hidden'],
        ]);

        Offer::create([
          'name' => $request->name,
          'slug' => $request->slug,
          'image' => $request->image->store('offers', ['disk' => 'public']),
          'description' => $request->description,
          'state' => $request->state,
        ]);

        return redirect()->route('dashboard');
    }

    public function edit($offerId)
    {
        return view('offers.edit', [
          'offer' => Offer::find($offerId),
        ]);
    }

    public function update(Request $request, $offerId)
    {
        $request->validate([
          'name' => ['required', 'string', 'max:255'],
          'slug' => ['required', 'string', 'max:255'],
          'image' => ['required', 'file'],
          'description' => ['nullable', 'string', 'max:255'],
          'state' => ['required', 'string', 'in:draft,published,hidden'],
        ]);

        Offer::find($offerId)->update(
          $request->all('name', 'slug', 'description', 'state')
        );

        if ($request->hasFile('image')) {
            Offer::find($offerId)->update(
              [
                'image' => $request->file('image')->store(
                  'offers',
                  ['disk' => 'public']
                ),
              ]
            );
        }

        return redirect()->route('dashboard');
    }

    public function destroy($offerId)
    {
        Offer::where('id', $offerId)->delete();

        return redirect()->route('dashboard');
    }

    // @todo ajouter pagination, cache
    public function show(string $offerId)
    {
        $offer = new OfferQuery($offerId);

        Event::dispatch($offer);

        return view('offers.show', compact('offer'));
    }

}
