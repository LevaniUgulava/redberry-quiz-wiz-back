<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Difficulty;
use Illuminate\Http\JsonResponse;

class FilterController extends Controller
{
    public function getDifficulties(): JsonResponse
    {
        $difficulties = Difficulty::select('id', 'name', 'hex')->get();

        return response()->json($difficulties);
    }

    public function getCategories(): JsonResponse
    {
        $categories = Category::select('id', 'name')->get();

        return response()->json($categories);
    }
}
