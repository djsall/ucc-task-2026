<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'requires_human', 'question', 'answer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
