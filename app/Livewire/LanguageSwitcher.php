<?php

namespace App\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public function switchLanguage(string $locale): void
    {
        if (! in_array($locale, ['ar', 'en'])) {
            abort(400);
        }

        session(['locale' => $locale]);
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
