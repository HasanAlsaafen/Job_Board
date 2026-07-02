<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

<head>
    @include('partials.head')
    @livewireStyles
    @filamentStyles
</head>

<body class="min-h-screen bg-gray-50 antialiased">
    {{ $slot }}

    @livewireScripts
    @filamentScripts
</body>

</html>
