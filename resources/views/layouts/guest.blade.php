<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">
<head>
    @include('partials.head')
    @livewireStyles
</head>
<body class="min-h-screen bg-brand-surface antialiased font-sans text-brand-ink">

    <nav class="fixed top-0 inset-x-0 z-10 bg-white border-b border-brand-border h-14 flex items-center px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <span class="font-display font-semibold text-sm text-brand-ink tracking-tight">Job Board</span>
        </a>
        <div class="{{ app()->isLocale('ar') ? 'mr-auto' : 'ml-auto' }}">
            <livewire:language-switcher />
        </div>
    </nav>

    <main class="min-h-screen flex items-center justify-center px-4 pt-14">
        {{ $slot }}
    </main>

    @livewireScripts
</body>
</html>
