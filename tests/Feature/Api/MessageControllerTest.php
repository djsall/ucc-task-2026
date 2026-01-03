<?php

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

test('user can list their own messages', function () {
    Message::factory()->count(3)->create(['user_id' => $this->user->id]);
    Message::factory()->for(User::factory())->create();

    $response = $this->getJson('/api/messages');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

test('user can submit a new question', function () {
    $response = $this->postJson('/api/messages', [
        'question' => 'How do I reset my password safely?',
    ]);

    $response->assertStatus(201)
        ->assertJsonPath('data.question', 'How do I reset my password safely?');

    $this->assertDatabaseHas('messages', [
        'user_id' => $this->user->id,
        'question' => 'How do I reset my password safely?',
    ]);
});

test('user cannot view someone else message', function () {
    $message = Message::factory()->for(User::factory())->create();

    $this->getJson("/api/messages/{$message->id}")
        ->assertStatus(403);
});

test('question validation rules are applied', function () {
    $this->postJson('/api/messages', ['question' => 'short'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['question']);
});
