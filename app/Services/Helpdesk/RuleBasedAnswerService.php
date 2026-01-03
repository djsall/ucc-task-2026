<?php

namespace App\Services\Helpdesk;

use App\Models\Message;
use App\Models\User;

class RuleBasedAnswerService
{
    public function __construct(protected User $user, protected Message $message) {}

    public function handle(): void
    {
        $question = str($this->message->question)->lower();

        if ($question->contains('human')) {
            $this->message->update([
                'requires_human' => true,
            ]);

            return;
        }

        if ($question->contains('password')) {
            $this->message->update([
                'answer' => 'To reset your password, please fill out the password reset form and check your email inbox.',
            ]);

            return;
        }

        if ($question->contains('event')) {
            $this->message->update([
                'answer' => 'To access and manage your events, please log in to your account. There, on the dashboard you will see all of them, where you can edit or delete them.',
            ]);

            return;
        }

        $this->message->update([
            'answer' => 'I’m not sure I understand your question. If you ask your question again with the `human` keyword inside, one of our colleagues will get back to you soon.',
        ]);
    }
}
