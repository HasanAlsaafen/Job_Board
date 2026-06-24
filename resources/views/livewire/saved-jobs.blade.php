<div
    x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
    @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' : '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen text-black bg-blue-50"
    dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}"
>

    @include('livewire.partials.seeker-sidebar', ['active' => 'savedJobs'])

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        <header class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl">
            <h1 class="text-xl font-bold text-gray-900">{{ __('messages.saved_jobs.title') }}</h1>
            <p class="text-sm text-gray-400 mt-0.5">{{ trans_choice('messages.saved_jobs.count', $jobs->count(), ['count' => $jobs->count()]) }}</p>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">

        @if($jobs->isEmpty())
            <div class="bg-white border border-dashed border-gray-200 rounded-xl p-12 text-center text-gray-400">
                <p class="font-medium text-gray-500">{{ __('messages.saved_jobs.empty') }}</p>
                <a href="{{ route('openings') }}" class="inline-block mt-3 text-sm text-blue-600 hover:underline font-medium">
                    {{ __('messages.saved_jobs.browse_openings') }}
                </a>
            </div>
        @else
            <div class="space-y-3">
                @foreach($jobs as $job)
                    <div class="bg-white border border-gray-100 rounded-xl px-6 py-5 shadow-sm hover:border-blue-300 hover:shadow-md transition duration-200">

                        <div class="flex justify-between items-start gap-3 mb-1">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $job->title }}</h3>
                                <p class="text-blue-600 text-sm font-medium mt-0.5">{{ $job->company_name }}</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-50 text-blue-600 border border-blue-100">
                                {{ $job->type }}
                            </span>
                        </div>

                        <p class="text-gray-500 text-sm my-3 line-clamp-2">{{ $job->description }}</p>

                        <div class="flex flex-wrap items-center justify-between pt-3 border-t border-gray-100 text-xs text-gray-400 gap-2">

                            <div class="flex items-center gap-3">
                                @if($job->location)
                                    <span class="flex items-center gap-1">
                                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $job->location }}
                                    </span>
                                @endif
                                @if($job->salary_range)
                                    <span class="text-green-600 font-semibold">{{ $job->salary_range }}</span>
                                @endif
                            </div>

                            <div class="flex items-center gap-2">
                                <button wire:click="unsaveJob({{ $job->id }})"
                                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition duration-150">
                                    <svg class="h-3.5 w-3.5 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <path d="M5 3a2 2 0 00-2 2v16l9-4 9 4V5a2 2 0 00-2-2H5z"/>
                                    </svg>
                                    {{ __('messages.saved_jobs.unsave') }}
                                </button>
                                <a href="{{ route('jobs.show', $job) }}" class="px-3 py-1.5 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-150">
                                    {{ __('View Details') }}
                                </a>
                            </div>

                        </div>

                    </div>
                @endforeach
            </div>
        @endif

    </div>

</div>
