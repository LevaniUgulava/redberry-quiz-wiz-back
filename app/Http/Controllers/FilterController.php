<?php

namespace App\Http\Controllers;

use App\Http\Resources\Filter\CategoryResource;
use App\Http\Resources\Filter\DifficultyResource;
use App\Models\Category;
use App\Models\Difficulty;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FilterController extends Controller
{
    public function difficulties(): AnonymousResourceCollection
    {
        $difficulties = Difficulty::all();

        return DifficultyResource::collection($difficulties);
    }

    public function categories(): AnonymousResourceCollection
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }
}
