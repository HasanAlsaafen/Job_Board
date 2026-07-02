<div x-data="{ collapsed: localStorage.getItem('sidebarCollapsed') === 'true' }" @sidebar-toggle.window="collapsed = $event.detail.collapsed"
    :class="collapsed ? '{{ app()->isLocale('ar') ? 'lg:mr-16' : 'lg:ml-16' }}' :
        '{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }}'"
    class="flex flex-col min-h-screen bg-gray-50 text-black" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'applicants'])
        <header
            class="bg-white border-b border-gray-100 py-4 px-4 lg:px-6 mt-4 lg:mt-8 mb-6 rounded-xl flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <a href="{{ route('employer.applicants') }}"
                    class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-blue-600 font-medium mb-1.5 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="{{ app()->isLocale('ar') ? 'M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3' : 'M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18' }}" />
                    </svg>
                    {{ __('messages.job_applicants.back') }}
                </a>
                <h1 class="text-xl font-bold text-gray-900">
                    {{ __('messages.job_applicants.heading', ['title' => $job->title]) }}
                </h1>
                <div class="flex items-center gap-2 mt-1">
                    <span class="text-xs font-medium text-gray-500">{{ $job->company_name }}</span>
                    <span class="text-gray-300">·</span>
                    <span
                        class="inline-flex items-center text-xs font-medium px-2 py-0.5 rounded-full
                        {{ $job->type === 'Full-time' ? 'bg-blue-50 text-blue-700' : ($job->type === 'Part-time' ? 'bg-violet-50 text-violet-700' : 'bg-amber-50 text-amber-700') }}">
                        {{ $job->type }}
                    </span>
                </div>
            </div>

            <span
                class="shrink-0 text-sm font-bold text-blue-600 bg-blue-50 border border-blue-100 px-4 py-2 rounded-xl">
                {{ trans_choice('messages.job_applicants.total', $applications->total(), ['count' => $applications->total()]) }}
            </span>
        </header>
    </div>

    <div class="px-4 lg:px-8 pb-8">

        @if ($applications->isEmpty())
            <div class="bg-white p-12 text-center rounded-2xl shadow-sm border border-dashed border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 size-10 text-gray-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <p class="font-medium text-gray-500">{{ __('messages.job_applicants.empty') }}</p>
            </div>
        @else
            @php
                $statusStyles = [
                    'Pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                    'Assessment in Progress' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'Interview' => 'bg-purple-50 text-purple-700 border-purple-200',
                    'Offer' => 'bg-green-50 text-green-700 border-green-200',
                    'Not proceeding' => 'bg-gray-50 text-gray-600 border-gray-200',
                    'Rejected' => 'bg-red-50 text-red-700 border-red-200',
                ];
            @endphp


            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 divide-y divide-gray-100 overflow-hidden">
                @foreach ($applications as $application)
                    <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-start justify-between gap-4"
                        wire:key="application-{{ $application->id }}">

                        <div class="flex items-start gap-3 flex-1 min-w-0">
                            <div
                                class="shrink-0 w-9 h-9 rounded-full bg-blue-100 text-blue-700 font-bold text-sm flex items-center justify-center uppercase">
                                @if ($application->user->profile->img_url)
                                    <img src="{{ Storage::url($application->user->profile->img_url) }}"
                                        alt="{{ $application->user->name }}"
                                        class="w-full h-full object-cover rounded-full">
                                @else
                                    {{ $application->user->initials() }}
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-gray-900 text-sm leading-snug">
                                    {{ $application->user->name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $application->user->email }}</p>

                                @if ($application->cover_letter)
                                    <div class="mt-2.5">
                                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">
                                            {{ __('messages.job_applicants.cover_letter') }}
                                        </p>
                                        <p
                                            class="text-xs text-gray-600 bg-gray-50 border border-gray-100 rounded-lg p-2.5 italic leading-relaxed line-clamp-3">
                                            {{ $application->cover_letter }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-xs text-gray-400 italic mt-1.5">
                                        {{ __('messages.job_applicants.no_cover_letter') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <div class="flex sm:flex-col items-center sm:items-end gap-2 shrink-0">
                            <span
                                class="inline-flex items-center text-xs font-semibold border px-2.5 py-1 rounded-lg {{ $statusStyles[$application->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }}">
                                {{ \App\Models\Applications::statusLabel($application->status) }}
                            </span>

                            @if ($application->resume_path)
                                <a href="{{ asset('storage/' . $application->resume_path) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 w-full justify-center text-xs font-semibold bg-white border border-gray-200 text-gray-700 hover:border-blue-300 hover:text-blue-700 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>
                                    {{ __('messages.job_applicants.view_resume') }}
                                </a>
                            @else
                                <span class="text-xs text-gray-400 px-3 py-1.5">
                                    {{ __('messages.job_applicants.no_resume') }}
                                </span>
                            @endif



                            <button wire:click="startConversation({{ $application->user_id }})"
                                class="mt-1 w-full inline-flex items-center justify-center gap-2 bg-brand-primary hover:bg-brand-primary-dark text-white font-semibold text-sm px-4 py-1.5 rounded-xl shadow-sm transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Message
                            </button>
                            <span class="text-xs text-gray-400">
                                {{ __('messages.job_applicants.applied_on', ['date' => $application->created_at->diffForHumans()]) }}
                            </span>
                        </div>

                    </div>
                @endforeach
            </div>

            @if ($applications->hasPages())
                <div class="mt-5">
                    {{ $applications->links() }}
                </div>
            @endif
        @endif

    </div>

</div>
