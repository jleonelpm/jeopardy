<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Turn extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'game_id',
        'team_id',
        'question_id',
        'is_correct',
        'points_awarded',
        'created_at',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_awarded' => 'integer',
        'created_at' => 'datetime',
    ];

    /**
     * Obtiene la partida del turno.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Obtiene el equipo que jugó el turno.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Obtiene la pregunta del turno.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
