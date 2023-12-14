<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Listing::class, 'listing');
    }
    public function index(Request $request)
    {
        //get and transform boolean value from request
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        $listings = Auth::user()->listings()
        ->filter($filters)
        ->withCount('images')
        ->withCount('offers')
        ->paginate(5)
        ->withQueryString();

        return inertia('Realtor/Index',
        [
            'filters' => $filters,
            'listings' => $listings
        ]);
    }

    public function show(Listing $listing)
    {
        // dd($listing->load('offers'));
        return inertia('Realtor/Show', [
            'listing' => $listing->load('offers', 'offers.bidder')
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'beds' => ['required', 'integer', 'min:0', 'max:20'],
            'baths' => ['required', 'integer', 'min:0', 'max:5'],
            'area' => ['required', 'integer', 'min:12', 'max:2000'],
            'city' => ['required'],
            'code' => ['required'],
            'street' => ['required'],
            'street_number' => ['required', 'min:1', 'max:2000'],
            'price' => ['required', 'integer', 'min:1'],
        ]);

        //save listing with relationship to user
        $request->user()->listings()->create([
            'beds' => $validatedData['beds'],
            'baths' => $validatedData['baths'],
            'area' => $validatedData['area'],
            'city' => $validatedData['city'],
            'code' => $validatedData['code'],
            'street' => $validatedData['street'],
            'street_number' => $validatedData['street_number'],
            'price' => $validatedData['price'],
        ]);

        return redirect()->route('realtor.listing.index')
        ->with('success', 'Listing created successfully!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return Inertia::render('Realtor/Edit', [
            'listing' => $listing
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $validatedData = $request->validate([
            'beds' => ['required', 'integer', 'min:0', 'max:20'],
            'baths' => ['required', 'integer', 'min:0', 'max:5'],
            'area' => ['required', 'integer', 'min:12', 'max:2000'],
            'city' => ['required'],
            'code' => ['required'],
            'street' => ['required'],
            'street_number' => ['required', 'min:1', 'max:2000'],
            'price' => ['required', 'integer', 'min:1'],
        ]);

        $listing->update([
            'beds' => $validatedData['beds'],
            'baths' => $validatedData['baths'],
            'area' => $validatedData['area'],
            'city' => $validatedData['city'],
            'code' => $validatedData['code'],
            'street' => $validatedData['street'],
            'street_number' => $validatedData['street_number'],
            'price' => $validatedData['price']
        ]);

        return redirect()->route('realtor.listing.index')
        ->with('success', 'Listing updated successfully!');
    }

    public function destroy(Listing $listing)
    {
        $listing->deleteOrFail();

        return redirect()->back()
            ->with('success', 'Listing was deleted!');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return back()->with('success', 'Listing restored successfully');
    }
}
