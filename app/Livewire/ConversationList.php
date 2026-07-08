<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\Component;

class ConversationList extends Component
{
    public function render()
    {
        $userId = auth()->id();

        $conversations = Conversation::with(['employer', 'seeker', 'jobListing', 'latestMessage'])
            ->where('employer_id', $userId)
            ->orWhere('seeker_id', $userId)
            ->orderByDesc('last_message_at')
            ->get();

        return view('livewire.conversation-list', compact('conversations'));
    }
}
