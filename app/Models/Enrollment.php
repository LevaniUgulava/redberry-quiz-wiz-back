<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

#[Fillable(['user_id', 'quiz_id','completed_at', 'points'])]
class Enrollment extends Model
{
    use HasFactory;
    #[Override]
    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
            'points' => 'float',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);

    }
}
