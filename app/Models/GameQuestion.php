<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameQuestion extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'question_id',
        'used',
        'created_at',
    ];

    protected $casts = [
        'used' => 'boolean',
        'created_at' => 'datetime',
    ];

    /**
     * Obtiene la partida.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Obtiene la pregunta.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
