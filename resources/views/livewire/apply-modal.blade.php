<div class="mt-4 border-t border-gray-100 pt-4">
    <h4 class="text-sm font-bold text-gray-900 mb-3">{{ __('messages.apply_modal.title') }}</h4>

    @if($this->isSaved)
        <div class="flex items-center gap-2 p-3 mb-3 text-sm text-green-700 bg-green-50 border border-green-200 rounded-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            {{ __('messages.applications.success') }}
        </div>
    @endif

    @error('application')
        <div class="p-3 mb-3 text-xs text-red-700 bg-red-50 border border-red-200 rounded-lg">{{ $message }}</div>
    @enderror

    <form wire:submit.prevent="submitApplication" class="space-y-3">
        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">
                {{ __('messages.apply_modal.resume_label') }}
                <span class="text-gray-400">{{ __('messages.apply_modal.resume_hint') }}</span>
            </label>
            <input type="file" wire:model="resume"
                   class="w-full text-xs text-gray-500
                          file:mr-3 file:py-1.5 file:px-3
                          file:rounded-md file:border file:border-gray-200
                          file:text-xs file:font-medium file:text-gray-700 file:bg-white
                          hover:file:bg-gray-50 file:transition file:cursor-pointer
                          cursor-pointer">
            @error('resume') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-xs font-medium text-gray-700 mb-1">
                {{ __('messages.apply_modal.cover_letter_label') }}
                <span class="text-gray-400">{{ __('messages.apply_modal.cover_letter_hint') }}</span>
            </label>
            <textarea wire:model="coverLetter" rows="3"
                      placeholder="{{ __('messages.apply_modal.cover_letter_placeholder') }}"
                      class="w-full text-sm border border-gray-200 rounded-lg px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
            @error('coverLetter') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
        </div>

        @auth
            @if(!$alreadyApplied)
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition">
                    {{ __('messages.jobs.apply') }}
                </button>
            @else
                <div class="w-full text-center text-sm text-gray-400 py-2 border border-gray-200 rounded-lg bg-gray-50">
                    {{ __('messages.applications.already_applied') }}
                </div>
            @endif
        @else
            <p class="text-sm text-gray-500 border border-gray-200 rounded-lg px-3 py-2 bg-gray-50">
                <a href="{{ route('login') }}" class="text-blue-600 font-medium hover:underline">{{ __('messages.auth.login') }}</a> {{ __('messages.apply_modal.login_to_apply') }}
            </p>
        @endauth
    </form>
</div>
