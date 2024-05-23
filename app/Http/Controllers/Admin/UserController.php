<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('User/Index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create($request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
            'password' => [
                'required',
                Password::min(8)
                        ->mixedCase()
                        ->letters()
                        ->numbers()
                        ->symbols()
                        ->uncompromised()],
            'role' => ['required'],
        ]));

        $user->assignRole($request->role);

        return to_route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::select('name','email')->findOrFail($id);
        return $user;
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validateWithPassword = [
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
            'password' => [
                'nullable',
                Password::min(8)
                    ->mixedCase()
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'role' => ['required'],
        ];
        $validateSinPassword = [
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
            'role' => ['required'],
        ];

        if($request->password == null){
            $validatedData = $request->validate($validateSinPassword);
        }else{
            $validatedData = $request->validate($validateWithPassword);
        }

        $user->update($validatedData);

        return redirect()->route('users.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::destroy($id);
    }

    public function getData(Request $request) {
        $query = User::query();
        $query->with('roles');

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

    function getRoles() {
        $roles = Role::all();
        return response()->json($roles);
    }
}
