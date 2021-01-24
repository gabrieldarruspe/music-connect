<?php

use App\Http\Controllers\ProviderTrackController;
use App\Http\Controllers\SpotifyLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/platform/{provider}/artists', [ProviderTrackController::class, 'index']);

Route::get('/platform/spotify/authenticate', [SpotifyLinkController::class, 'redirectToAuthentication']);
Route::get('/platform/spotify/callback', [SpotifyLinkController::class, 'authenticationCallback']);
Route::delete('/platform/spotify/unlink', [SpotifyLinkController::class, 'unlinkAccount']);

Route::get('/users/me/music-libraries/{provider}/saved-tracks', [ProviderTrackController::class, 'index']);

require __DIR__.'/auth.php';
