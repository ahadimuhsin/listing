<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load(['images']);
        return inertia('Realtor/ListingImage/Create', [
            'listing' => $listing
        ]);
    }

    public function store(Listing $listing, Request $request)
    {
        if($request->hasFile('images'))
        {
            $request->validate([
                'images' => 'array',
                'images.*' => ['image', 'max:5000']
            ], [
                'images.*.image' => 'The file should be image'
            ]);

            foreach($request->file('images') as $file)
            {
                $path = $file->store('images', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
        }

        return redirect()->back()->with('success','Images uploaded succesfully');
    }

    public function destroy($listing, $image_id)
    {
        $listingImage = ListingImage::findOrFail($image_id);
        Storage::disk('public')->delete($listingImage->filename);
        $listingImage->delete();

        return redirect()->back()->with('success', 'Image deletes succesfully');
    }
}
