<?php

namespace App\Livewire\Admin;

use App\Models\Applications;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.bare')]
class AdminApplications extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public bool $showEditModal = false;
    public ?int $editingId = null;
    public string $editStatus = '';
    public string $successMessage = '';

    public const STATUSES = [
        'Pending',
        'Assessment in Progress',
        'Interview',
        'Offer',
        'Not proceeding',
        'Rejected',
        'Withdrawn',
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function editApplication(Applications $application): void
    {
        $this->editingId     = $application->id;
        $this->editStatus    = $application->status;
        $this->showEditModal = true;
        $this->successMessage = '';
    }

    public function updateApplication(): void
    {
        $this->validate([
            'editStatus' => 'required|in:' . implode(',', self::STATUSES),
        ], [], ['editStatus' => 'status']);

        Applications::findOrFail($this->editingId)->update(['status' => $this->editStatus]);

        $this->successMessage = 'Status updated.';
    }

    public function cancelEdit(): void
    {
        $this->showEditModal = false;
        $this->editingId = null;
        $this->reset(['editStatus', 'successMessage']);
    }

    public function render()
    {
        $applications = Applications::with(['user', 'jobListing'])
            ->when($this->search, fn($q) => $q->whereHas('user', fn($u) => $u->where('name', 'like', '%' . $this->search . '%'))
                ->orWhereHas('jobListing', fn($j) => $j->where('title', 'like', '%' . $this->search . '%')))
            ->when($this->statusFilter, fn($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(15);

        return view('livewire.admin.applications', ['applications' => $applications]);
    }
}
