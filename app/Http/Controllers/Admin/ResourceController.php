<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function getResources() {
        try {
            $selectedName = request('name');
            $resources = Resource::orderBy('id', 'asc')
                ->when($selectedName, function($query) use($selectedName){
                    $query->where('name', 'like', '%' .$selectedName. '%');
                })
                ->paginate(5);
            return response()->json($resources);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get resources Api Error";
            return response()->json($e);
        }
    }

    public function createResource(Request $request)
    {
        try {
            $this->validate($request, [
                "name" => "required",
            ]);
            return Resource::create([
                'name'  => $request->name,
                'slug'  => $request->slug,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Add resource Api Error";
            return response()->json($e);
        }
    }

    public function updateResource(Request $request, $id) {
        try {
            $this->validate($request, [
                "name" => "required",
            ]);
            $resource = Resource::findOrFail($id);
            $resource->name = $request->name;
            $resource->slug = $request->slug;
            $resource->save();
            return $resource;
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Update resource Api Error";
            return response()->json($e);
        }
    }

    public function deleteResource($id) {
        try {
            return Resource::where('id', $id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Resource delete api error";
            return response()->json($e);
        }
    }
}
