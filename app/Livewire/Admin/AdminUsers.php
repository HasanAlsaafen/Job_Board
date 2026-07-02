<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.bare')]
class AdminUsers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';

    public bool $showEditModal = false;
    public ?int $editingId = null;
    public string $editName = '';
    public string $editEmail = '';
    public string $editRole = '';
    public string $successMessage = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingRoleFilter(): void
    {
        $this->resetPage();
    }

    public function editUser(User $user): void
    {
        $this->editingId = $user->id;
        $this->editName  = $user->name;
        $this->editEmail = $user->email;
        $this->editRole  = $user->role;
        $this->showEditModal = true;
        $this->successMessage = '';
    }

    public function updateUser(): void
    {
        $this->validate([
            'editName'  => 'required|min:2|max:255',
            'editEmail' => 'required|email|unique:users,email,' . $this->editingId,
            'editRole'  => 'required|in:seeker,employer,admin',
        ], [], [
            'editName'  => 'name',
            'editEmail' => 'email',
            'editRole'  => 'role',
        ]);

        User::findOrFail($this->editingId)->update([
            'name'  => $this->editName,
            'email' => $this->editEmail,
            'role'  => $this->editRole,
        ]);

        $this->successMessage = 'User updated successfully.';
    }

    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    public function cancelEdit(): void
    {
        $this->showEditModal = false;
        $this->editingId = null;
        $this->reset(['editName', 'editEmail', 'editRole', 'successMessage']);
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            }))
            ->when($this->roleFilter, fn($q) => $q->where('role', $this->roleFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.users', ['users' => $users]);
    }
}
