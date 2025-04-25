<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' . config('app.name') : config('app.name') }}</title>

    {{-- Cropper.js --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-nav sticky class="lg:hidden">
        <x-slot:brand>
            <x-app-brand />
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden me-3">
                <x-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-nav>

    {{-- MAIN --}}
    <x-main>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100">

            {{-- BRAND --}}
            <x-app-brand class="px-5 pt-3" />

            {{-- MENU --}}
            <x-menu activate-by-route class="pt-1">

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-menu-separator />

                    <div class="flex gap-2 items-center justify-between px-3 py-2">
                        <div class="flex items-center space-x-3">

                            @if (Auth::user()->avatar)
                                <div class="avatar avatar-online">
                                    <div class="w-8 rounded-full border border-success">
                                        <img src="{{ Auth::user()->path_avatar }}" />
                                    </div>
                                </div>
                            @else
                                <div class="avatar avatar-online avatar-placeholder">
                                    <div class="bg-base-300 text-base-content w-8 rounded-full border border-success">
                                        <span>{{ Auth::user()->getInitials() }}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mary-hideable">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                <div class="text-sm text-gray-400 font-extralight">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <x-dropdown right mary-hideable>
                            <x-slot:trigger>
                                <x-button icon="o-cog-6-tooth" class="btn-circle text-primary" />
                            </x-slot:trigger>
                            <x-menu-item title="Profile" icon="o-user" icon-classes="text-secondary"
                                link="{{ route('account.profile') }}" />
                            <x-menu-item title="Change Password" icon="o-key" icon-classes="text-secondary"
                                link="{{ route('account.change-password') }}" />
                            <x-menu-item title="Toggle theme" icon="o-swatch" icon-classes="text-secondary"
                                @click="$dispatch('mary-toggle-theme')" />
                            <x-menu-separator />
                            <x-menu-item title="Log Out" icon="o-power" icon-classes="text-error" class="text-sm" x-data
                                @click.prevent="if (confirm('Are you sure you want to log out?')) $refs.logoutForm.submit()" />
                            <form x-ref="logoutForm" id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none">
                                @csrf
                            </form>
                        </x-dropdown>
                    </div>

                    <x-menu-separator />
                @endif

                <x-menu-item title="Dashboard" icon="o-chart-pie" icon-classes="text-primary"
                    link="{{ route('dashboard') }}" />

                <x-menu-sub title="Settings" icon="o-cog-6-tooth" icon-classes="text-primary">
                    <x-menu-item title="User" icon="o-users" icon-classes="text-secondary"
                        link="{{ route('user') }}" />
                </x-menu-sub>
            </x-menu>
        </x-slot:sidebar>

        {{-- The `$slot` goes here --}}
        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-main>

    {{-- Theme toggle --}}
    <x-theme-toggle class="hidden" />

    {{--  TOAST area --}}
    <x-toast position="toast-bottom" />
</body>

</html>
