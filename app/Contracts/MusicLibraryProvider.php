<?php


namespace App\Contracts;


use App\Models\User;

interface MusicLibraryProvider
{
    public function __construct(User $user);

    public function getUserSavedTracks();
}
