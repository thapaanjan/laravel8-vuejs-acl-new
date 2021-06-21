<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getRoles() {
        try {
            $selectedName = request('name');
            $roles = Role::orderBy('id', 'asc')
                ->when($selectedName, function($query) use($selectedName){
                    $query->where('name', 'like', '%' .$selectedName. '%');
                })
                ->paginate(5);
            return response()->json($roles);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get roles Api Error";
            return response()->json($e);
        }
    }

    public function createRole(Request $request)
    {
        try {
            $this->validate($request, [
                "name" => "required",
                "description" => "required"
            ]);
            return Role::create([
                'name'  => $request->name,
                'slug'  => $request->slug,
                'description' => $request->description,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Add role Api Error";
            return response()->json($e);
        }
    }

    public function updateRole(Request $request, $id) {
        try {
            $this->validate($request, [
                "name" => "required",
                "description" =>"required"
            ]);
            $role = Role::findOrFail($id);
            $role->name = $request->name;
            $role->slug = $request->slug;
            $role->description = $request->description;
            $role->save();
            return $role;
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Update role Api Error";
            return response()->json($e);
        }
    }

    public function deleteRole($id) {
        try {
            return Role::where('id', $id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Role delete api error";
            return response()->json($e);
        }
    }
}
