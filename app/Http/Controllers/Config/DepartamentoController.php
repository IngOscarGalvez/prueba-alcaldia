<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\Departamento;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DepartamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Config/Departamentos/Index',[
            'title' => 'departamentos',
            'name_route' => 'departamentos'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Departamento = Departamento::create($request->validate([
            'name' => ['required', 'max:255'],
        ]));

        return to_route('departamentos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Departamento::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $Departamento = Departamento::findOrFail($id);
        $validate = [
            'name' => ['required', 'max:255'],
        ];
        $validatedData = $request->validate($validate);
        $Departamento->update($validatedData);

        return redirect()->route('departamentos.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Departamento = Departamento::destroy($id);
    }

    public function getData(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = Departamento::query();

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
