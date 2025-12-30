<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'question_text',
        'correct_answer',
        'points',
        'time_limit',
        'is_used',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'points' => 'integer',
        'time_limit' => 'integer',
    ];

    /**
     * Obtiene la categoría a la que pertenece la pregunta.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Obtiene los turnos relacionados a esta pregunta.
     */
    public function turns(): HasMany
    {
        return $this->hasMany(Turn::class);
    }

    /**
     * Obtiene los juegos en los que esta pregunta fue utilizada.
     */
    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'game_questions')
            ->withPivot('used')
            ->withTimestamps();
    }
}
