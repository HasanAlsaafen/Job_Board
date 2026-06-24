<div class="flex items-center gap-1">
    <button
        wire:click="switchLanguage('ar')"
        class="px-3 py-1 text-sm rounded-md transition
        {{ app()->getLocale() === 'ar' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        العربية
    </button>
    <button
        wire:click="switchLanguage('en')"
        class="px-3 py-1 text-sm rounded-md transition
        {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        English
    </button>
</div>
