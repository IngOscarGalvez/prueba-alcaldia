<?php

namespace App\Http\Controllers\Config;

use App\Http\Controllers\Controller;
use App\Models\Config\TipoIdentificacion;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoIdentificacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Config/TipoIdentificacion/Index',[
            'title' => 'Tipo Identificación',
            'name_route' => 'tipoIdentificacion'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $TipoIdentificacion = TipoIdentificacion::create($request->validate([
            'name' => ['required', 'max:255'],
        ]));

        return to_route('tipoIdentificacion.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return TipoIdentificacion::findOrFail($id);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $TipoIdentificacion = TipoIdentificacion::findOrFail($id);
        $validate = [
            'name' => ['required', 'max:255'],
        ];
        $validatedData = $request->validate($validate);
        $TipoIdentificacion->update($validatedData);

        return redirect()->route('tipoIdentificacion.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $TipoIdentificacion = TipoIdentificacion::destroy($id);
    }

    public function getData(Request $request): \Illuminate\Http\JsonResponse
    {
        $query = TipoIdentificacion::query();

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
