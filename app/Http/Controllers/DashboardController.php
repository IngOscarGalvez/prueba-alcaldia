<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }

    public function getCategories(): \Illuminate\Http\JsonResponse
    {
        $categories = Category::with(['components' => function ($query) {
            $query->withCount('items');
        }])->get();

        $data = $categories->map(function ($category) {
            $totalItemsPerCategory = 0;
            $components = $category->components->map(function ($component) use (&$totalItemsPerCategory) {
                $totalItemsPerCategory += $component->items_count;
                return [
                    'component_id' => $component->id,
                    'component_name' => $component->name,
                    'items_count' => $component->items_count, // Contador de items por componente directamente de la relación
                ];
            });

            return [
                'category_id' => $category->id,
                'category_name' => $category->name,
                'total_items' => $totalItemsPerCategory, // Sumatoria total de items por categoría
                'components' => $components,
            ];
        });

        return response()->json($data);
    }
}
