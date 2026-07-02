<?php

namespace App\Livewire;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Notifications\NewDirectMessage;
use Livewire\Component;

class ChatBox extends Component
{
    public Conversation $conversation;
    public string $newMessage = '';

    public function mount(Conversation $conversation): void
    {
        if (
            auth()->id() !== $conversation->employer_id &&
            auth()->id() !== $conversation->seeker_id
        ) {
            abort(403);
        }

        $conversation->messages()
            ->where('user_id', '!=', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->conversation = $conversation;
    }

    public function getListeners(): array
    {
        return [
            "echo-private:conversation.{$this->conversation->id},MessageSent" => 'receiveMessage',
        ];
    }

    public function receiveMessage(array $data): void
    {
        $this->dispatch('message-received');
    }

    public function send(): void
    {
        $this->validate(['newMessage' => 'required|min:1|max:1000']);

        $message = $this->conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $this->newMessage,
        ]);

        $this->conversation->update(['last_message_at' => now()]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        $recipient = $this->conversation->otherParticipant();
        $recipient->notify(new NewDirectMessage($message));

        $this->newMessage = '';

        $this->dispatch('message-received');
    }

    public function render()
    {
        return view('livewire.chat-box', [
            'messages' => $this->conversation->messages()->with('user')->get(),
            'otherParticipant' => $this->conversation->otherParticipant(),
        ]);
    }
}