<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    @include('partials.head')
    @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 antialiased">

    <nav class="fixed top-0 inset-x-0 z-10 bg-white text-black border-b border-gray-100 px-6 h-14 flex items-center justify-between">
        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
            <span class="text-base font-black text-gray-900 tracking-tight">Job Board</span>
        </a>
        <livewire:language-switcher />
    </nav>

    <main class="min-h-screen bg-white text-black flex items-center justify-center px-4 pt-14">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
