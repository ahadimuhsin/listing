<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'index', 'show'
        ]])->only(['store', 'create', 'update', 'edit']);

        $this->authorizeResource(Listing::class, 'listing');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request_filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);
        $query = Listing::with('owner')->mostRecent()->filter($request_filters)->withoutSold()->paginate(12)->withQueryString();

        return Inertia::render('Listing/Index', [
            'filters' => $request_filters,
            'listings' => $query,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $listing->load(['images']);

        $offer = !auth()->user() ?
        null :
        $listing->offers()->byMe()->first() ;

        return Inertia::render('Listing/Show', [
            'listing' => $listing,
            'offerMade' => $offer
        ]);
    }

}
