<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'question_id',
        'played_at',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
