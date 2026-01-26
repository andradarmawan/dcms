<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Update Profile --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete User --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            {{-- MICROSOFT ACCOUNT --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl space-y-4">

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                        Microsoft Account
                    </h3>

                    @if(empty($msAccount['connected']))
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Microsoft account belum terhubung ke akun Anda.
                        </p>

                        <a href="{{ route('auth.microsoft') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600
                                text-white rounded-md hover:bg-blue-700 transition">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg"
                                class="w-4 h-4">
                            Connect Microsoft
                        </a>
                    @else
                        <div class="rounded-md bg-green-50 dark:bg-green-900/30 p-3 text-sm">
                            <p class="text-green-800 dark:text-green-300 font-medium">
                                ✅ Microsoft account terhubung
                            </p>
                        </div>

                        <dl class="text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex justify-between py-1">
                                <dt>Email</dt>
                                <dd>{{ $msAccount['email'] ?? '-' }}</dd>
                            </div>
                        </dl>

                        <dl class="text-sm text-gray-700 dark:text-gray-300">
                            <div class="flex justify-between py-1">
                                <dt>Connected At</dt>
                                <dd>
                                    {{ \Carbon\Carbon::parse($msAccount['connected_at'])
                                        ->locale('id')
                                        ->translatedFormat('d F Y H:i') }} WIB
                                </dd>
                            </div>
                        </dl>

                        <div class="flex gap-3 pt-2">
                            <a href="{{ route('auth.microsoft') }}"
                            class="px-4 py-2 border rounded-md text-sm
                                    hover:bg-gray-100 dark:hover:bg-gray-700">
                                Reconnect
                            </a>

                            <button
                                type="button"
                                data-open-disconnect-modal
                                class="px-4 py-2 rounded-md border border-red-500 text-sm text-red-600 hover:bg-red-50">
                                Disconnect
                            </button>

                            @include('components.modals.disconnect-microsoft')
                        </div>
                    @endif

                </div>
            </div>


        </div>
    </div>
</x-app-layout>