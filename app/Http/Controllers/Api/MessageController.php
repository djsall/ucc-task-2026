<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Services\Helpdesk\RuleBasedAnswerService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): JsonResource
    {
        $messages = $request->user()->messages()->latest()->get();

        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request): JsonResource
    {
        $user = $request->user();
        $message = $user->messages()->create($request->validated());

        (new RuleBasedAnswerService($message))->handle();

        return MessageResource::make($message->fresh());
    }

    public function show(Message $message): JsonResource
    {
        $this->authorize('view', $message);

        return MessageResource::make($message);
    }
}
