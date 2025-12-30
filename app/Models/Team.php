<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'name',
        'color',
        'score',
    ];

    protected $casts = [
        'score' => 'integer',
    ];

    /**
     * Obtiene la partida a la que pertenece el equipo.
     */
    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    /**
     * Obtiene los turnos del equipo.
     */
    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }

    /**
     * Aumenta el puntaje del equipo.
     */
    public function addScore(int $points): void
    {
        $this->increment('score', $points);
    }

    /**
     * Disminuye el puntaje del equipo.
     */
    public function subtractScore(int $points): void
    {
        $this->decrement('score', $points);
    }
}
