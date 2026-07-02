<?php

namespace App\Livewire;

use App\Services\ChatbotService;
use Livewire\Component;

class Chatbot extends Component
{
    public string $message = '';
    public array $history = [];
    public bool $isOpen = false;
    public bool $isLoading = false;
    public ?string $cvText = null;
    public bool $hasCv = false;
    public function mount(ChatbotService $chatbot): void
    {
        $user = auth()->user();
        $resumePath = $user->profile?->resume_path;

        if ($resumePath) {
            $this->cvText = $chatbot->extractTextFromFile($resumePath);
            $this->hasCv = !empty($this->cvText);
        }
    }
    public function sendMessage(ChatbotService $chatbot): void
    {
        if (empty(trim($this->message))) return;

        $userMessage = $this->message;
        $this->message = '';

        $this->history[] = [
            'role' => 'user',
            'content' => $userMessage,
        ];

        $response = $chatbot->chat($userMessage, $this->history, $this->cvText);

        $this->history[] = [
            'role' => 'model',
            'content' => $response,
        ];
    }

    public function clearHistory(): void
    {
        $this->history = [];
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}
