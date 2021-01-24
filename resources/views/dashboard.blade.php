<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div x-data="app()" class="py-12">
        <template x-if="typeof user !== undefined">
            <div
                class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <x-button
                            x-show="!('spotify' in user.oauth_providers)"
                            @click="window.location.href='/platform/spotify/authenticate'">
                            Connect to Spotify
                        </x-button>
                        <form x-show="'spotify' in user.oauth_providers"
                              @submit.prevent="unlinkAccount()"

                        >
                            <x-button type="submit">Unlink Spotify Account</x-button>
                        </form>
                    </div>
                </div>
            </div>
        </template>
    </div>
    <script>
        function app() {
            return {
                user: @json(Auth::user()),
                unlinkAccount() {
                    fetch('/platform/spotify/unlink', {
                        method: 'DELETE',
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content
                        },
                    }).then( x => {
                        delete this.user.oauth_providers.spotify;
                    })
                }
            }
        }
    </script>
</x-app-layout>
