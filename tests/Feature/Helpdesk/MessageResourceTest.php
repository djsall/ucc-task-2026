<?php

use App\Filament\Resources\Messages\Pages\ManageMessages;
use App\Models\Message;
use App\Models\User;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Illuminate\Foundation\Testing\RefreshDatabase;

use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->actingAs(User::factory()->helpdesk()->create());
});

it('can list messages', function () {
    $messages = Message::factory()->forRandomUser()->count(5)->create();

    livewire(ManageMessages::class)
        ->assertCanSeeTableRecords($messages)
        ->assertCountTableRecords(5);
});

it('displays the correct status icon based on the answer', function () {
    $unanswered = Message::factory()->forRandomUser()->unanswered()->create();
    $answered = Message::factory()->forRandomUser()->create();

    livewire(ManageMessages::class)
        ->assertTableColumnStateSet('requires_human', false, record: $unanswered)
        ->assertTableColumnStateSet('requires_human', true, record: $answered);
});

it('filters unanswered messages correctly', function () {
    $unanswered = Message::factory()->forRandomUser()->unanswered()->create();
    $answered = Message::factory()->forRandomUser()->create();

    livewire(ManageMessages::class)
        ->filterTable('hide_answered', true)
        ->assertCanSeeTableRecords([$unanswered])
        ->assertCanNotSeeTableRecords([$answered]);
});

it('shows Edit action only when unanswered and View action only when answered', function () {
    $unanswered = Message::factory()->forRandomUser()->unanswered()->create();
    $answered = Message::factory()->forRandomUser()->create();

    livewire(ManageMessages::class)
        // Check Unanswered record
        ->assertTableActionVisible(EditAction::class, $unanswered)
        ->assertTableActionHidden(ViewAction::class, $unanswered)
        // Check Answered record
        ->assertTableActionHidden(EditAction::class, $answered)
        ->assertTableActionVisible(ViewAction::class, $answered);
});

it('can search by question', function () {
    $message = Message::factory()->forRandomUser()->create(['question' => 'How do I test this?']);
    $otherMessage = Message::factory()->forRandomUser()->create(['question' => 'Something else']);

    livewire(ManageMessages::class)
        ->searchTable('How do I test')
        ->assertCanSeeTableRecords([$message])
        ->assertCanNotSeeTableRecords([$otherMessage]);
});

it('can update an answer', function () {
    $message = Message::factory()->forRandomUser()->unanswered()->create();
    $answer = 'This is the new response.';

    livewire(ManageMessages::class)
        ->callTableAction(EditAction::class, $message, data: [
            'answer' => $answer,
        ])
        ->assertHasNoTableActionErrors();

    expect($message->refresh()->answer)->toBe($answer);
});
