<?php

namespace App\Http\Controllers;

use App\Services\MusicLibraryManager;
use App\Services\SpotifyMusicLibraryProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProviderTrackController extends Controller
{
    public function index(Request $request, string $provider)
    {
       $manager = (new MusicLibraryManager(new SpotifyMusicLibraryProvider(Auth::user())));
       $tracks = $manager->getUserTracks();
       return response($tracks, 200);
    }
}
