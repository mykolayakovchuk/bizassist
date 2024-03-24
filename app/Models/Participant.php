<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    /**
     * Получить данные пользователя, участника чата.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить данные какому чату соответсвует этот участник
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }
}
