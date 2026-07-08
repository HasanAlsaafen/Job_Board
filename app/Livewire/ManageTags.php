<?php

namespace App\Livewire;

use App\Models\Tag;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Str;

#[Layout('layouts.bare')]

class ManageTags extends Component
{
    public string $name = '';
    public string $color = '#ffffff';
    public string $bg = '#3B82F6';
    public string $successMessage = '';
    public string $errorMessage = '';

    public function createTag(): void
    {
        $this->validate([
            'name' => 'required|min:2|max:50|unique:tags,name',
            'color' => 'required',
            'bg'    => 'required',
        ]);

        Tag::create([
            'name'  => $this->name,
            'slug'  => Str::slug($this->name),
            'color' => $this->color,
            'bg'    => $this->bg,
        ]);

        $this->reset(['name', 'color', 'bg']);
        $this->color = '#ffffff';
        $this->bg = '#3B82F6';
        $this->successMessage = 'Tag created successfully!';
    }

    public function deleteTag(Tag $tag): void
    {
        $tag->delete();
    }

    public function render()
    {
        return view('livewire.manage-tags', [
            'tags' => Tag::latest()->get(),
        ]);
    }
}
