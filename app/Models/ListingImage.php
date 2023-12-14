<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ListingImage extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ["src"];
    public function src():Attribute
    {
        return Attribute::make(
            get: fn () => asset("storage/{$this->filename}")
        );
    }
    public function listing(): BelongsTo
    {
    return $this->belongsTo(Listing::class, 'listing_id');
    }
}
