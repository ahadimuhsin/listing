<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Notifications\OfferAccepted;
use DB;
use Illuminate\Http\Request;

class RealtorListingAcceptController extends Controller
{
    public function __invoke(Offer $offer)
    {
        $this->authorize('update', $offer->listing);

        DB::beginTransaction();
        try {
            # code...
                    //Accept selected offer
            $offer->update([
                'accepted_at' => now()
            ]);

            $offer->listing->update([
                'sold_at' => now()
            ]);

            //Reject all other offers
            $offer->listing->offers()->except($offer)->update([
                'rejected_at' => now()
            ]);

            $offer->bidder->notify(
                new OfferAccepted($offer)
            );

            DB::commit();
        } catch (\Throwable $e) {
            # code...
            DB::rollBack();

            return back()->with('error', 'Terjadi Kesalahan '.$e->getMessage());
        }


        return back()->with('success', "Offer #{$offer->id} accepted, other offers rejected!");
    }
}
