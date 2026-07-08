<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if (app()->isLocale('ar'))
        <style>
            body {
                font-family: 'Cairo', sans-serif;
            }
        </style>
    @endif
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>

<body class="bg-brand-surface antialiased min-h-screen font-sans text-brand-ink"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <header class="bg-white border-b border-brand-border sticky right-0 z-50">
        <div class="max-w-screen-xl mx-auto px-6 h-14 flex items-center justify-between gap-4">
            <span class="font-display font-bold text-brand-ink text-base tracking-tight">Job Board</span>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('logout') }}"
                        class="font-sans text-sm font-medium text-brand-muted hover:text-red-600 border border-brand-border hover:border-red-200 px-3 py-2 rounded-md transition">
                        {{ __('messages.auth.logout') }}
                    </a>
                    <livewire:notification-bell />
                    <livewire:push-subscription />
                @else
                    <a href="{{ route('login') }}"
                        class="font-sans text-sm font-medium text-brand-muted hover:text-brand-ink transition">
                        {{ __('messages.auth.login') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="font-sans text-sm font-medium text-white bg-brand-primary hover:bg-brand-primary-dark px-4 py-2 rounded-md transition">
                        {{ __('messages.auth.register') }}
                    </a>
                @endauth
            </div>
        </div>
    </header>

    @livewire('jobs-feed')

</body>

</html>
