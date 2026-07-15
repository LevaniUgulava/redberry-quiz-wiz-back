<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

#[Fillable(['user_id', 'difficulty_id', 'title', 'points', 'time_limit'])]
class Quiz extends Model
{
    #[Override]
    protected function casts(): array
    {
        return [
            'points' => 'float',
            'time_limit' => 'integer',
        ];
    }

    public function difficulty(): BelongsTo
    {
        return $this->belongsTo(Difficulty::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_quiz');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }
}
