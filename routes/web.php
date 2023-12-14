<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\RealtorListingAcceptController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [IndexController::class, 'index']);
Route::get('/hello', [IndexController::class, 'show']);

Route::resource('user-account', UserAccountController::class)
->only(['create', 'store']);
Route::get('login', [AuthController::class, 'create'])->name('login');
Route::post('login', [AuthController::class, 'store'])->name('login.store');

Route::resource('listing', ListingController::class)->only(['index', 'show']);
Route::resource('listing.offer', ListingOfferController::class)->middleware(['auth', 'verified'])
->only(['store']);
Route::group(['middleware' => ['auth']], function () {
    Route::delete('logout', [AuthController::class, 'destroy'])->name('logout');
});

Route::put('notification/{notification}/seen', [NotificationController::class, 'markAsRead'])
->middleware(['auth', 'verified'])->name('notification.seen');

Route::resource('notification', NotificationController::class)
->middleware(['auth', 'verified'])->only(['index', 'show']);

Route::prefix('realtor')
->name('realtor.')
->middleware(['auth', 'verified'])
->group(function(){
    Route::put('listing/{listing}/restore', [RealtorListingController::class, 'restore'])
    ->name('listing.restore')->withTrashed();
    Route::resource('listing', RealtorListingController::class)
    ->withTrashed();

    Route::resource('listing.image', RealtorListingImageController::class)
    ->only(['create', 'store', 'destroy']);

    Route::put("offer/{offer}/accept", RealtorListingAcceptController::class)
    ->name("offer.accept");
});

// Email Verification
Route::get('/email/verify', function () {
    return inertia('Auth/Email/Verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('listing.index')
    ->with('success', 'Email successfully verified');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
