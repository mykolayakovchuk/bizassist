<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    /**
     * Получить комментарии к посту блога.
     */
    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    /**
     * Получить комментарии к посту блога.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
