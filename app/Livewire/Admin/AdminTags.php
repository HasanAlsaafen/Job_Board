<?php

namespace App\Livewire\Admin;

use App\Models\Tag;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.bare')]
class AdminTags extends Component
{
    public string $name = '';
    public string $color = '#1e3a5f';
    public string $bg = '#dbeafe';
    public string $successMessage = '';

    public bool $showEditModal = false;
    public ?int $editingId = null;
    public string $editName = '';
    public string $editColor = '';
    public string $editBg = '';

    public function createTag(): void
    {
        $this->validate([
            'name'  => 'required|min:2|max:50|unique:tags,name',
            'color' => 'required',
            'bg'    => 'required',
        ]);

        Tag::create([
            'name'  => $this->name,
            'slug'  => Str::slug($this->name),
            'color' => $this->color,
            'bg'    => $this->bg,
        ]);

        $this->reset(['name']);
        $this->color = '#1e3a5f';
        $this->bg    = '#dbeafe';
        $this->successMessage = 'Tag created.';
    }

    public function editTag(Tag $tag): void
    {
        $this->editingId   = $tag->id;
        $this->editName    = $tag->name;
        $this->editColor   = $tag->color;
        $this->editBg      = $tag->bg;
        $this->showEditModal = true;
    }

    public function updateTag(): void
    {
        $this->validate([
            'editName'  => 'required|min:2|max:50|unique:tags,name,' . $this->editingId,
            'editColor' => 'required',
            'editBg'    => 'required',
        ], [], [
            'editName'  => 'name',
            'editColor' => 'color',
            'editBg'    => 'background',
        ]);

        Tag::findOrFail($this->editingId)->update([
            'name'  => $this->editName,
            'slug'  => Str::slug($this->editName),
            'color' => $this->editColor,
            'bg'    => $this->editBg,
        ]);

        $this->showEditModal = false;
        $this->editingId = null;
        $this->successMessage = 'Tag updated.';
    }

    public function deleteTag(Tag $tag): void
    {
        $tag->delete();
    }

    public function cancelEdit(): void
    {
        $this->showEditModal = false;
        $this->editingId = null;
        $this->reset(['editName', 'editColor', 'editBg']);
    }

    public function render()
    {
        return view('livewire.admin.tags', [
            'tags' => Tag::withCount('jobListings')->latest()->get(),
        ]);
    }
}
