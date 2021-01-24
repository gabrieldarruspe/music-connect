<?php


namespace App\Services;


use App\Contracts\MusicLibraryProvider;

class MusicLibraryManager
{
    protected $provider;

    public function __construct(MusicLibraryProvider $musicLibraryProvider)
    {
        $this->provider = $musicLibraryProvider;
    }

    public function getUserTracks()
    {
        return $this->provider->getUserSavedTracks();
    }
}
