<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Category/Index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Category = Category::create($request->validate([
            'name' => ['required', 'max:255'],
        ]));

        return to_route('category.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Category::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Category = Category::findOrFail($id);
        $validate = [
            'name' => ['required', 'max:255'],
        ];
        $validatedData = $request->validate($validate);
        $Category->update($validatedData);

        return redirect()->route('category.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Category = Category::destroy($id);
    }

    public function getData(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Category::query();

        if ($request->has('sortKey') && $request->has('sortOrder')) {
            if($request->sortKey != '' && $request->sortOrder != '' && $request->sortOrder != 'none'){
                $query->orderBy($request->sortKey, $request->sortOrder);
            }
        }

        if ($request->has('columnFilters')) {
            if($request->columnFilters != ''){
                foreach ($request->columnFilters as $key => $value) {
                    $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }

        $perPage = $request->input('perPage', 10);
        $currentPage = $request->input('page', 1);

        $total = $query->count();

        if($perPage > 0){
            $data = $query
                ->skip(($currentPage - 1) * $perPage)
                ->take($perPage)
                ->get();
        }else{
            $data = $query
                ->get();
        }

        return response()->json([
            'data' => $data,
            'total' => $total,
        ]);
    }
}
