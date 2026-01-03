<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $messages = $request->user()->messages()->latest()->paginate();

        return MessageResource::collection($messages);
    }

    public function store(StoreMessageRequest $request)
    {
        $message = $request->user()->messages()->create($request->validated());

        return MessageResource::make($message);
    }

    public function show(Message $message)
    {
        $this->authorize('view', $message);

        return MessageResource::make($message);
    }
}
