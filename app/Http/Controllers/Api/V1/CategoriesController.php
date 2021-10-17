<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function create(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string|min:2',
                'description' => 'required|string|min:2'
            ]);

            $category = Category::create($fields);

            if (!$category) {
                return response()->json(['message' => 'Request data is not valid'], 422);
            }

            return response()->json(['category' => $category]);
        } catch (QueryException $exception) {
            return response()->json(['message' => $exception->getMessage()], 422);
        }
    }
}
