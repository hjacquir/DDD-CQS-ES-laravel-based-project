<?php

namespace App\Infrastructure\Database\Eloquent\Models;

use App\Domain\State;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public static $states = [
        'draft' => 'Brouillon',
        'published' => 'Publié',
        'invisible' => 'Invisible',
        // @todo à enlever
        State::Published->name => 'Publié',
    ];

    protected $fillable = [
        'offer_id',
        'name',
        'sku',
        'image',
        'price',
        'state',
    ];

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
}
