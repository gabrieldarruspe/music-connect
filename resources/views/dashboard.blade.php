<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">

        <div
            class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div x-data="app()" x-init="init()" class="p-6 bg-white border-b border-gray-200">
                    <template x-if="typeof user !== undefined">
                        <div class="flex">
                            <x-button
                                class="m-auto"
                                x-show="!userHasProvider('spotify')"
                                @click="window.location.href='/platform/spotify/authenticate'">
                                Connect to Spotify
                            </x-button>

                            <x-button
                                class="m-auto"
                                x-show="userHasProvider('spotify')"
                                @click="unlinkAccount()">
                                Unlink Spotify Account
                            </x-button>
                        </div>
                    </template>
                    <template x-if="tracks.length">
                        <div
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-90"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            class="my-4">
                            <template x-for="track in tracks" :key="track.provider_track_id">
                                <div class="p-2">
                                    <div
                                        class="shadow-lg bg-white dark:bg-gray-800 rounded-xl sm:rounded-t-xl p-4 pb-6 sm:p-8 lg:p-4 lg:pb-6 xl:p-8 space-y-6 sm:space-y-8 lg:space-y-6 xl:space-y-8">
                                        <div
                                            class="flex items-center space-x-3.5 sm:space-x-5 lg:space-x-3.5 xl:space-x-5">
                                            <img :src="track.album_image_url" width="160" height="160"
                                                 class="flex-none w-20 h-20 rounded-lg bg-gray-100"/>
                                            <div class="min-w-0 flex-auto space-y-0.5">
                                                <p class="text-lime-600 dark:text-lime-400 text-sm sm:text-base lg:text-sm xl:text-base font-semibold uppercase">
                                                    <span x-text="track.artists[0].name"></span>
                                                </p>
                                                <h2 class="text-black dark:text-white text-base sm:text-xl lg:text-base xl:text-xl font-semibold truncate">
                                                    <span x-text="track.name"></span>
                                                </h2>
                                                <p class="text-gray-500 dark:text-gray-400 text-base sm:text-lg lg:text-base xl:text-lg font-medium">
                                                    <span x-text="track.album.name"></span>
                                                </p>
                                            </div>
                                            <div>
                                                <audio controls="controls">
                                                    <source :src="track.preview_url" type="audio/mpeg"/>
                                                </audio>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                </div>
            </div>
        </div>

    </div>
    <script>
        function app() {
            return {
                user: @json(Auth::user()),
                tracks: {},
                unlinkAccount() {
                    fetch('/platform/spotify/unlink', {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                    }).then(x => {
                        delete this.user.oauth_providers.spotify;
                        this.showDiv = true;
                    });
                },
                getUserTracks() {
                    fetch('/users/me/music-libraries/spotify/saved-tracks', {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                    })
                        .then(response => response.json())
                        .then(data => this.tracks = data);
                },
                userHasProvider(providerName){
                    return this.user.oauth_providers !== null && providerName in this.user.oauth_providers;
                },
                init() {
                    if (this.userHasProvider('spotify')) {
                        this.getUserTracks();
                    }
                }
            }
        }
    </script>
</x-app-layout>
