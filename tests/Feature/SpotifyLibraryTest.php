<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SpotifyLibraryTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_get_spotify_saved_tracks(): void
    {
        $user = User::factory()->withSpotifyAccount()->create();
        $response = $this->actingAs($user)->get('/users/me/music-libraries/spotify/saved-tracks');

//        dump($response->content());
        $response->assertStatus(200);

        $response->assertJsonStructure(['*' => [
            'name', 'artists', 'album_image_url', 'preview_url', 'added_at'
        ]]);
    }
}
