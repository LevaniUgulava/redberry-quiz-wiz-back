<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name'])]
class Category extends Model
{
    use HasFactory;

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'category_quiz');
    }
}
