<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Resource;
use App\Models\Permission;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        // Uncomment below code if not using "middleware('auth:admin'); in __construct function"

        // if(!Auth::guard('admin')->check() && ($request->path() !=="auth/login" || $request->path()==="auth/login")) {
        //     return redirect()->intended(route('admin.login'));
        // }
        $user = Auth::guard('admin')->user();        
        return $this->checkAdminResource($user, $request);
    }

    public function checkAdminResource($user, $request) {
        $adminResources =$user->resources;
        $hasResource = false;

        if (!$adminResources) {
            return view('master');
        }

        $path = explode("/", $request->path());
        if(empty($path[0] && empty($path[1]))){
            $link = "dashboard";
        }else {
            if (!empty($path[1]))
                $link = $path[1];
            else if (!empty($path[0]))
                $link = $path[0];
        }
        foreach($adminResources as $resource) {            
           if($resource->slug === $link) {
                $hasResource = true;
           }
        }
        if($hasResource) {
            return view('master');
        } else {
            return view('403');
        }     
    }

    public function getPermissions() {
        try {
            $permissions = Permission::orderBy('id', 'asc')->get();
            return response()->json($permissions);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get permissions Api Error";
            return response()->json($e);
        }
    }
    public function getResources() {
        try {
            $resources = Resource::orderBy('id', 'asc')->get();
            return response()->json($resources);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get resources Api Error";
            return response()->json($e);
        }
    }

}
