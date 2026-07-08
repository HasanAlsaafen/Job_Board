<?php

use App\Livewire\ChatBox;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

beforeEach(function () {
    Notification::fake();
});

test('sent chat messages show a read receipt indicator when read_at is present', function () {
    $sender = User::factory()->create();
    $recipient = User::factory()->create();

    $conversation = Conversation::create([
        'employer_id' => $sender->id,
        'seeker_id' => $recipient->id,
        'last_message_at' => now(),
    ]);

    Message::create([
        'conversation_id' => $conversation->id,
        'user_id' => $sender->id,
        'body' => 'Hello there',
        'read_at' => now(),
    ]);

    Livewire::actingAs($sender)
        ->test(ChatBox::class, ['conversation' => $conversation])
        ->assertSee('Read');
});
