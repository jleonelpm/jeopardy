<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'is_published',
        'current_turn_team_id',
        'num_rows',
        'selected_categories',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_published' => 'boolean',
        'selected_categories' => 'array',
    ];

    /**
     * Obtiene el moderador (usuario) que creó la partida.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene los equipos de la partida.
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * Obtiene el equipo actualmente en turno.
     */
    public function currentTurnTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_turn_team_id');
    }

    /**
     * Obtiene los turnos de la partida.
     */
    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }

    /**
     * Obtiene las preguntas asignadas a esta partida.
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class, 'game_questions')
            ->withPivot('used')
            ->withTimestamps();
    }

    /**
     * Obtiene los registros de game_questions.
     */
    public function gameQuestions(): HasMany
    {
        return $this->hasMany(GameQuestion::class);
    }
}
