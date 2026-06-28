<div class="{{ app()->isLocale('ar') ? 'lg:mr-64' : 'lg:ml-64' }} flex flex-col min-h-screen bg-white text-black" dir="{{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}">

    <div class="px-4 lg:px-8 pt-16 lg:pt-0">
        @include('livewire.partials.employer-sidebar', ['active' => 'jobs'])

        <header class="bg-white shadow-sm py-5 mb-8 flex items-center justify-between pl-2 pr-4 lg:px-6 mt-4 lg:mt-8 rounded-2xl">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('messages.my_jobs.title') }}</h1>
                <p class="text-sm text-gray-400 mt-0.5">{{ __('messages.my_jobs.subtitle') }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" class="text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg transition shadow-sm">
                    {{ __('messages.my_jobs.post_a_job') }}
                </a>
                <a href="{{ route('logout') }}" class="text-sm text-red-500 hover:text-red-700 border border-red-200 hover:border-red-400 px-3 py-2 rounded-lg transition hover:bg-red-50">
                    {{ __('messages.auth.logout') }}
                </a>
            </div>
        </header>
    </div>

    <div class="space-y-4 px-4 lg:px-8 pb-8">
        @if($myJobs->isEmpty())
            <div class="bg-white p-12 text-center rounded-2xl text-gray-400 shadow-sm border border-dashed border-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3 size-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.073a2.25 2.25 0 0 1-2.25 2.25h-12a2.25 2.25 0 0 1-2.25-2.25V6a2.25 2.25 0 0 1 2.25-2.25h4.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 3h4.5m0 0v4.5m0-4.5-6 6" />
                </svg>
                <p class="font-medium text-gray-500">{{ __('messages.my_jobs.empty') }}</p>
                <p class="text-sm mt-1">{{ __('messages.my_jobs.empty_hint') }}
                    <a href="{{ route('dashboard') }}" class="ml-1 text-blue-600 hover:underline font-medium">{{ __('messages.my_jobs.post_one_now') }}</a>
                </p>
            </div>
        @endif

        @foreach($myJobs as $job)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md hover:border-gray-200 transition-all duration-200 overflow-hidden" wire:key="job-{{$job->id}}">

                <div class="p-5 sm:p-6">
                    <div class="flex items-start gap-4">

                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-base font-bold text-gray-900 leading-snug">{{ $job->title }}</h3>
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $job->company_name }}</p>
                                </div>

                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-700 bg-blue-50 border border-blue-100 px-3 py-1.5 rounded-full">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        {{ trans_choice('messages.my_jobs.applicants', $job->applications_count, ['count' => $job->applications_count]) }}
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center gap-2 mt-3">
                                <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full
                                    {{ $job->type === 'Full-time' ? 'bg-blue-50 text-blue-700' : ($job->type === 'Part-time' ? 'bg-violet-50 text-violet-700' : ($job->type === 'Remote' ? 'bg-emerald-50 text-emerald-700' : 'bg-amber-50 text-amber-700')) }}">
                                    {{ $job->type }}
                                </span>

                                @if($job->salary_range)
                                    <span class="inline-flex items-center gap-1 text-xs font-medium text-gray-600 bg-gray-50 px-2.5 py-1 rounded-full border border-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        {{ $job->salary_range }}
                                    </span>
                                @endif

                                @if($job->created_at)
                                    <span class="inline-flex items-center gap-1 text-xs text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        {{ $job->created_at->diffForHumans() }}
                                    </span>
                                @endif
                            </div>

                            @if($job->description)
                                <p class="mt-3 text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $job->description }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between">
                        <div>
                            <button
                                wire:click="deleteJob({{ $job->id }})"
                                wire:confirm="{{ __('messages.my_jobs.delete_confirm') }}"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-1.5 rounded-lg transition border border-transparent hover:border-red-100"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                {{ __('messages.my_jobs.delete') }}
                            </button>
                            <button
                                wire:click="editJob({{ $job->id }})"
                                class="inline-flex items-center gap-1.5 text-xs font-medium text-blue-500 hover:text-blue-700 hover:bg-blue-50 px-3 py-1.5 rounded-lg transition border border-transparent hover:border-blue-100"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                </svg>
                                {{ __('messages.my_jobs.edit') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg p-6" @click.stop>

            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-gray-900">{{ __('messages.my_jobs.edit_modal_title') }}</h2>
                <button wire:click="cancelEdit" class="text-gray-400 hover:text-gray-600 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            @if($successMessage)
                <div class="p-3 mb-4 text-xs font-bold text-green-700 bg-green-50 rounded-xl border border-green-200">
                    {{ $successMessage }}
                </div>
            @endif

            <form wire:submit.prevent="updateJob" class="space-y-4 text-sm">
                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.job_title') }}</label>
                    <input type="text" wire:model="title" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900">
                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.company_name') }}</label>
                    <input type="text" wire:model="company_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900">
                    @error('company_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.location') }}</label>
                    <input type="text" wire:model="location" placeholder="{{ __('messages.job_form.location_placeholder') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900">
                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.employment_type') }}</label>
                    <select wire:model="type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900">
                        <option value="Full-time">{{ __('messages.job_form.full_time') }}</option>
                        <option value="Part-time">{{ __('messages.job_form.part_time') }}</option>
                        <option value="Contract">{{ __('messages.job_form.contract') }}</option>
                    </select>
                    @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-2">
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.tags') }}</label>
                    <div class="flex flex-wrap gap-2 p-3 bg-gray-50 border border-gray-200 rounded-lg min-h-[44px]">
                        @php $availableTags = $tags->filter(fn($t) => !in_array((string)$t->id, $selectedTagIds)); @endphp
                        @forelse ($availableTags as $tag)
                            <label class="cursor-pointer select-none">
                                <input type="checkbox" wire:model.live="selectedTagIds" value="{{ $tag->id }}" class="hidden">
                                <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold opacity-65 hover:opacity-100 hover:shadow-sm transition-all duration-150">
                                    {{ $tag->name }}
                                </span>
                            </label>
                        @empty
                            <span class="text-xs text-gray-400 self-center italic">All tags selected</span>
                        @endforelse
                    </div>
                    @if (count($selectedTagIds) > 0)
                        <div class="p-3 border border-blue-100 bg-blue-50 rounded-lg">
                            <p class="text-xs font-medium text-blue-400 mb-2">{{ count($selectedTagIds) }} {{ count($selectedTagIds) === 1 ? 'tag' : 'tags' }} chosen</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($tags->whereIn('id', $selectedTagIds) as $tag)
                                    <span style="color: {{ $tag->color }}; background-color: {{ $tag->bg }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold shadow-sm">
                                        {{ $tag->name }}
                                        <button type="button" wire:click="removeTag({{ $tag->id }})"
                                            class="opacity-60 hover:opacity-100 transition-opacity leading-none">
                                            <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.salary_range') }}</label>
                    <input type="text" wire:model="salary_range" placeholder="{{ __('messages.job_form.salary_placeholder') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.description') }}</label>
                    <textarea wire:model="description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900"></textarea>
                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">{{ __('messages.job_form.requirements') }}</label>
                    <textarea wire:model="requirements" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none text-gray-900"></textarea>
                    @error('requirements') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center gap-3 pt-1">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition">
                        {{ __('messages.my_jobs.save_changes') }}
                    </button>
                    <button type="button" wire:click="cancelEdit" class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 font-medium py-2.5 rounded-xl transition">
                        {{ __('messages.my_jobs.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
