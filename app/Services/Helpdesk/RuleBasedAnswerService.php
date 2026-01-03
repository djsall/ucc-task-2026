<?php

namespace App\Services\Helpdesk;

use App\Models\Message;

class RuleBasedAnswerService
{
    public function __construct(protected Message $message) {}

    public function handle(): void
    {
        $question = str($this->message->question)->lower();

        match (true) {
            $question->contains('human') => $this->requiresHumanReview(),
            $question->contains('password') => $this->automaticAnswer(__('answers.reset-password')),
            $question->contains('event') => $this->automaticAnswer(__('answers.event')),
            default => $this->requiresHumanReview(),
        };
    }

    private function requiresHumanReview(): void
    {
        $this->message->update([
            'requires_human' => true,
        ]);
    }

    private function automaticAnswer(string $answer): void
    {
        $this->message->update([
            'answer' => $answer,
        ]);
    }
}
