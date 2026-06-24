<div
    x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' : '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen text-black bg-blue-50"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}"
>

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.seeker-sidebar', ['active' => 'myApplications'])

        <header class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl">
            <h1 class="text-xl font-bold text-gray-900">{{ __('messages.my_applications.title') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ trans_choice('messages.my_applications.submitted', $applications->count(), ['count' => $applications->count()]) }}</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">
        @php
            $statusStyles = [
                'Pending'               => 'bg-yellow-50 text-yellow-700 border border-yellow-200',
                'Assesment in Progress' => 'bg-blue-50 text-blue-700 border border-blue-200',
                'Interview'             => 'bg-purple-50 text-purple-700 border border-purple-200',
                'Offer'                 => 'bg-green-50 text-green-700 border border-green-200',
                'Not proceding'         => 'bg-gray-100 text-gray-500 border border-gray-200',
                'Rejected'              => 'bg-red-50 text-red-700 border border-red-200',
                'Withdrawn'             => 'bg-orange-50 text-orange-700 border border-orange-200',
            ];
        @endphp

        @if($applications->isEmpty())
            <div class="bg-white border border-dashed border-gray-200 rounded-xl p-12 text-center text-gray-400">
                <p class="font-medium text-gray-500">{{ __('messages.my_applications.empty') }}</p>
                <a href="{{ route('openings') }}" class="inline-block mt-3 text-sm text-blue-600 hover:underline font-medium">{{ __('messages.my_applications.browse_openings') }}</a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($applications as $application)
                    <div class="bg-white border border-gray-100 rounded-xl p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-bold text-gray-900">{{ $application->jobListing->title }}</h3>
                                <p class="text-sm text-blue-600 mt-0.5">{{ $application->jobListing->company_name }}</p>
                            </div>
                            <span class="shrink-0 text-xs font-medium bg-gray-100 text-gray-600 px-2.5 py-1 rounded-md">
                                {{ $application->jobListing->type }}
                            </span>
                        </div>

                        @if($application->cover_letter)
                            <p class="text-sm text-gray-500 mt-3 bg-gray-50 rounded-lg px-3 py-2 italic line-clamp-2">
                                {{ $application->cover_letter }}
                            </p>
                        @endif
                        @if ($application->status === 'Withdrawn')
                            <p class="text-xs text-orange-600 bg-orange-50 border border-orange-200 rounded-lg px-3 py-2 mt-3">
                                {{ __('messages.my_applications.withdrawn') }}
                            </p>
                        @elseif (!in_array($application->status, ['Rejected', 'Not proceding']))
                            <div class="mt-3">
                                <button
                                    wire:click="withdraw({{ $application->id }})"
                                    wire:confirm="{{ __('messages.my_applications.withdraw_confirm') }}"
                                    class="text-xs font-medium text-red-700 bg-red-50 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-100 transition">
                                    {{ __('messages.my_applications.withdraw') }}
                                </button>
                            </div>
                        @endif
                        <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 gap-3 flex-wrap">
                            <div class="flex items-center gap-2">
                                <span class="text-xs {{ $statusStyles[$application->status] ?? 'bg-gray-100 text-gray-500' }} px-2.5 py-1 rounded-md font-medium">
                                    {{ $application->translated_status }}
                                </span>
                                <span class="text-xs text-gray-400">{{ __('messages.my_applications.applied') }} {{ $application->created_at->diffForHumans() }}</span>
                            </div>
                            <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                               class="text-xs font-medium text-green-700 bg-green-50 border border-green-200 px-3 py-1.5 rounded-lg hover:bg-green-100 transition flex items-center gap-1">
                                {{ __('messages.my_applications.resume') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
