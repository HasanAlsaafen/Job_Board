<div x-data="{ open: false }"
    class="relative bg-white text-black rounded-full w-30 h-10 flex items-center justify-center cursor-pointer">


    <button @click="open = !open" class="relative">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        @if ($unreadCount > 0)
            <span
                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs
                rounded-full w-3 h-3 flex items-center justify-center">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" x-transition @click.outside="isOpen = false"
        class="absolute top-[50px] -left-[180px] w-[240px] bg-white z-50 rounded-xl shadow-xl border border-[#c3bfbf]  max-h-[400px]">

        <div class="flex justify-between items-center p-4 border-b">
            <span class="font-bold">Notifications</span>
            @if ($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-blue-600 hover:underline">
                    Mark all as read
                </button>
            @endif
        </div>

        <div class="max-h-80 overflow-y-auto divide-y divide-gray-200">
            @forelse ($notifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" wire:click="markAsRead('{{ $notification->id }}')"
                    class="block p-4 hover:bg-gray-50 transition
                        {{ $notification->read_at ? 'opacity-60' : 'bg-blue-50' }}">

                    <p class="text-sm font-medium text-gray-800">
                        {{ $notification->data['message'] }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">
                        {{ $notification->created_at->diffForHumans() }}
                    </p>

                    @if (!$notification->read_at)
                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mt-1"></span>
                    @endif
                </a>
            @empty
                <p class="text-center text-gray-400 p-6 text-sm">
                    No notifications
                </p>
            @endforelse
        </div>
    </div>
</div>
