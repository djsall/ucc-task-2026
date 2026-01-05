<?php

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create();
    Sanctum::actingAs($this->user);
});

it('can list events belonging to the user', function () {

    Event::factory()->count(3)->create(['user_id' => $this->user->id]);
    Event::factory()->for(User::factory())->create();

    $response = $this->getJson('/api/events');

    $response->assertStatus(200)
        ->assertJsonCount(3, 'data');
});

it('can create a new event', function () {
    $payload = [
        'name' => 'Laravel Meetup',
        'occurrence' => now()->addDays(7),
        'description' => 'A gathering of PHP enthusiasts.',
    ];

    $response = $this->postJson('/api/events', $payload);

    $response->assertStatus(201)
        ->assertJsonPath('data.name', 'Laravel Meetup');

    $this->assertDatabaseHas('events', [
        'user_id' => $this->user->id,
        'name' => $payload['name'],
        'occurrence' => $payload['occurrence']->toDateTimeString(),
        'description' => $payload['description'],
    ]);
});

it('can update an existing event description', function () {
    $event = Event::factory()->create(['user_id' => $this->user->id]);

    $response = $this->putJson("/api/events/{$event->id}", [
        'description' => 'Updated Event description',
    ]);

    $response->assertStatus(200);
    expect($event->refresh()->description)->toBe('Updated Event description');
});

it('can delete an event', function () {
    $event = Event::factory()->create(['user_id' => $this->user->id]);

    $response = $this->deleteJson("/api/events/{$event->id}");

    $response->assertStatus(204);
    $this->assertDatabaseMissing('events', ['id' => $event->id]);
});

it('cannot view an event belonging to another user', function () {
    $otherEvent = Event::factory()->for(User::factory())->create();

    $response = $this->getJson("/api/events/{$otherEvent->id}");

    $response->assertStatus(403);
});

it('validates required fields when creating an event', function () {
    $response = $this->postJson('/api/events', []);

    $response->assertStatus(422)
        ->assertJsonValidationErrors(['name']);
});
