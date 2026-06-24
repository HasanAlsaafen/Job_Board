<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"
    dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Job Board</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @if(app()->getLocale() === 'ar')
        <style> body { font-family: 'Cairo', sans-serif; } </style>
    @endif
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</head>
<body class="bg-gray-50 antialiased min-h-screen" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <header class="bg-white shadow-md py-4 mb-8 flex items-center justify-around px-4 sticky top-0 z-50">
        <div>

            @auth
                <a href="{{ route('logout') }}" class="text-sm text-red-600 hover:underline border border-red-600 px-3 py-1.5 rounded-lg transition hover:bg-red-50">
                    {{ __('messages.auth.logout') }}
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">{{ __('messages.auth.login') }}</a>
                <span class="mx-2 text-gray-400">|</span>
                <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">{{ __('messages.auth.register') }}</a>
            @endauth
        </div>
    </header>

    @livewire('jobs-feed')

</body>
</html>
