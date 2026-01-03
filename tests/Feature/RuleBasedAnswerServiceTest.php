<?php

use App\Models\Message;
use App\Models\User;
use App\Services\Helpdesk\RuleBasedAnswerService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires human review when the question contains "human"', function () {
    $message = Message::factory()->for(User::factory())->create([
        'question' => 'I need to speak to a human please',
        'requires_human' => false,
    ]);

    (new RuleBasedAnswerService($message))->handle();

    expect($message->fresh()->requires_human)->toBeTrue();
});

it('provides a password reset answer when the question contains "password"', function () {
    $message = Message::factory()->for(User::factory())->create([
        'question' => 'How do I change my password?',
    ]);

    (new RuleBasedAnswerService($message))->handle();

    expect($message->fresh()->answer)->toBe(__('answers.reset-password'));
});

it('provides an event answer when the question contains "event"', function () {
    $message = Message::factory()->for(User::factory())->create([
        'question' => 'Tell me about the next event',
    ]);

    (new RuleBasedAnswerService($message))->handle();

    expect($message->fresh()->answer)->toBe(__('answers.event'));
});

it('defaults to human review if no keywords match', function () {
    $message = Message::factory()->for(User::factory())->create([
        'question' => 'What is the meaning of life?',
        'requires_human' => false,
    ]);

    (new RuleBasedAnswerService($message))->handle();

    $message->refresh();
    expect($message->requires_human)->toBeTrue()
        ->and($message->answer)->toBeNull();
});

it('is case insensitive', function () {
    $message = Message::factory()->for(User::factory())->create([
        'question' => 'PASSWORD RESET',
    ]);

    (new RuleBasedAnswerService($message))->handle();

    expect($message->fresh()->answer)->toBe(__('answers.reset-password'));
});
