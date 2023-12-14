<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, HasUlids, SoftDeletes;

    protected $guarded = [];

    protected $sortable = [
        'price', 'created_at'
    ];
    public function uniqueIds()
    {
        // Tell Laravel you want to use ULID for your secondary 'ulid' column instead
        return [
            'ulid',
        ];
    }

    // public function getRouteKeyName()
    // {
    //     return 'ulid';
    // }

    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function scopeMostRecent(Builder $query)
    {
        return $query->latest();
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        // dd($filters['deleted']);
         return $query->when($filters['priceFrom'] ?? false,
            fn($query, $value) => $query->where('price', '>=', $value)
            )->when($filters['priceTo'] ?? false,
            fn($query, $value) => $query->where('price', '<=', $value)
            )->when($filters['beds'] ?? false,
            fn($query, $value) => $query->where('beds', (int) $value < 6 ? "=" : ">=", $value)
            )->when($filters['baths'] ?? false,
            fn($query, $value) => $query->where('baths', (int) $value < 6 ? "=" : ">=", $value)
            )->when($filters['areaFrom'] ?? false,
            fn($query, $value) => $query->where('area', '>=', $value)
            )->when($filters['areaTo'] ?? false,
            fn($query, $value) => $query->where('area', '<=', $value)
            )->when($filters['deleted'] ?? false,
            fn($query) => $query->withTrashed()
            )->when($filters['by'] ?? false,
            fn($query, $value) =>
            !in_array($value, $this->sortable) ? $query :
            $query->orderBy($value, $filters['order'] ?? 'desc'))
            ;
    }

    public function scopeWithoutSold(Builder $query): Builder
    {
        // return $query->doesntHave('offers')
        // ->orWhereHas("offers", function($query) {
        //     return $query->whereNull("accepted_at")->whereNull("rejected_at");
        // });
        return $query->whereNull('sold_at');
    }

    public function images():HasMany
    {
        return $this->hasMany(ListingImage::class, 'listing_id');
    }

    public function offers()
    {
        return $this->hasMany(Offer::class, 'listing_id');
    }
}
