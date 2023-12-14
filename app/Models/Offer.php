<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Offer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function listing()
    {
        return $this->belongsTo(Listing::class, 'listing_id');
    }

    public function bidder()
    {
        return $this->belongsTo(User::class,'bidder_id', 'id');
    }

    public function scopeByMe(Builder $query) : Builder
    {
        return $query->where('bidder_id', auth()?->id());
    }

    public function scopeExcept(Builder $query, Offer $offer) : Builder
    {
        return $query->where('id', '!=', $offer->id);
    }
}
