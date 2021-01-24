<?php


namespace App\Services;


use App\Contracts\MusicLibraryProvider;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class SpotifyMusicLibraryProvider implements MusicLibraryProvider
{
    protected $baseUrl = 'https://api.spotify.com/v1';

    protected $tokenData;

    protected $accessToken;

    public function __construct(User $user)
    {
        $this->tokenData = $user->oauth_providers['spotify'];
        $this->accessToken = $this->tokenData['access_token'];
    }

    public function getUserSavedTracks()
    {
        $endpoint = '/me/tracks';
        $url = $this->baseUrl . $endpoint;
        $response = Http::withToken($this->accessToken)->get($url);

        //TODO update to work with pagination
        return $this->transformTracks($response->json()['items']);
    }

    protected function transformTracks(array $spotifyTracks): array
    {
        return collect($spotifyTracks)->transform(function ($trackItem) {
            $track = $trackItem['track'];
            return [
                'name' => $track['name'],
                'artists' => $track['artists'],
                'album_image_url' => $track['album']['images'][0]['url'],
                'preview_url' => $track['preview_url'],
                'added_at' => $trackItem['added_at'],
            ];
        })->toArray();

    }
}
