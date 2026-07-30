<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Override;

#[Fillable(['user_id', 'difficulty_id', 'title', 'points', 'time_limit', 'image_url'])]
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

    public function fullImageUrl(): Attribute
    {
        return Attribute::make(
            get: fn (): string => Storage::disk('public')->url($this->image_url)
        );
    }

    public function completedPoints(): Attribute
    {
        return Attribute::make(
            get: fn (): ?int => $this->enrollments->where('user_id', Auth::id())->first()?->points ?? null
        );
    }

    public function completedAt(): Attribute
    {
        return Attribute::make(
            get: fn (): ?Carbon => $this->enrollments->where('user_id', Auth::id())->first()?->completed_at ?? null
        );
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['search'] ?? null, function (Builder $query, string $search) {
                $query->where('title', 'like', '%'.$search.'%');
            })->when($filters['category'] ?? null, function (Builder $query, array $category) {
                $query->whereHas('categories', function (Builder $query) use ($category) {
                    $query->whereIn('category_id', $category);
                });
            })->when($filters['difficulty'] ?? null, function (Builder $query, array $difficulty) {
                $query->whereHas('difficulty', function (Builder $query) use ($difficulty) {
                    $query->whereIn('difficulty_id', $difficulty);
                });
            })->when($filters['sort_by'] ?? null, function (Builder $query, string $sortBy) {
                match ($sortBy) {
                    'a-z' => $query->orderby('title', 'asc'),
                    'z-a' => $query->orderby('title', 'desc'),
                    'newest' => $query->orderby('created_at', 'desc'),
                    'oldest' => $query->orderby('created_at', 'asc'),
                    'most-popular' => $query->orderBy('enrollments_count', 'desc'),
                    default => $query

                };
            })->when(Auth::check() ? ($filters['filter'] ?? null) : null,
                function (Builder $query, string $filter) {
                    $user_id = Auth::id();
                    match ($filter) {
                        'my_quizzes' => $query->whereHas('enrollments', function (Builder $query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        }),
                        'not_completed' => $query->whereDoesntHave('enrollments', function (Builder $query) use ($user_id) {
                            $query->where('user_id', $user_id);
                        })
                    };

                    return $query;
                });

    }
}
