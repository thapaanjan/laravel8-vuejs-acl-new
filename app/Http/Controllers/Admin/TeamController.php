<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Resource;
use App\Models\AdminResource;
use App\Models\Role;
use App\Models\AdminRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminPermission;

class TeamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function getAllRoles() {
        try {
            $roles = Role::orderBy('id', 'asc')->get();
            return response()->json($roles);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get all roles Api Error";
            return response()->json($e);
        }
    }
    public function getTeams() {
        try {
            $adminRole = Auth::guard('admin')->user()->roles[0]->slug;
            $selectedName = request('name');
            $selectedEmail = request('email');
            $selectedRole = request('role');
            $selectedPhone = request('phone');
            $teams = Admin::with(['roles','resources','permissions'])
                ->when(($adminRole !=='super_admin'),function($query){
                    $query->whereHas('roles', function ($q){
                        $q->where('roles.slug', '!==','super_admin');
                    });
                })
                ->when($selectedName, function($query) use($selectedName) {
                    $query->where('name', 'like', '%' .$selectedName.'%');
                })
                ->when($selectedEmail, function($query) use($selectedEmail) {
                    $query->where('email',$selectedEmail);
                })
                ->when($selectedPhone, function($query) use($selectedPhone) {
                    $query->where('phone_number', $selectedPhone);
                })
                ->when(isset($selectedRole), function($query) use($selectedRole) {
                    $query->whereHas('roles', function ($q) use($selectedRole){
                        $roles= explode(',',$selectedRole);
                        $q->whereIn('roles.id', $roles);
                    });
                })
                ->orderBy('id', 'desc')
                ->paginate(5);

            // $query = Admin::query();
            // if($adminRole!=='super_admin'){
            //     $query->whereHas('roles', function ($q){
            //         $q->where('roles.slug', '!=','super_admin');
            //     });
            // }
            // if ($selectedName) {
            //     $query = $query->where('name', 'like', '%' .$selectedName.'%');
            // }
            // if ($selectedEmail) {
            //     $query->where('email',$selectedEmail);
            // }
            // if ($selectedRole) {
            //     $query->whereHas('roles', function ($q) use($selectedRole){
            //         $roles= explode(',',$selectedRole);
            //         $q->whereIn('roles.id', $roles);
            //     });
            // }
            // if($selectedPhone){
            //     $query->where('phone_number', $selectedPhone);
            // }
            // $teams = $query->with(['roles','resources','permissions'])->orderBy('id', 'desc')->paginate(10);


            return response()->json($teams);
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Get teams Api Error";
            return response()->json($e);
        }
    }

    public function createTeam(Request $request) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                "name" => "required",
                "email" =>"bail|required|email|unique:admins",
                "phone_number" => "bail|required|numeric"
            ]);
            $admin = new Admin;
            $admin->name            = $request->name;
            $admin->email           = $request->email;
            $admin->phone_number    = $request->phone_number;
            $admin->password        = Hash::make(123456);
            $admin->save();

            AdminRole::create([
                "role_id"   =>  $request->role_id,
                "admin_id"  =>  $admin->id
            ]);
            
            $date = date('Y-m-d h:i:s');
            $adminResources = [];
            $adminPermissions = [];

            if (!empty($request->resources)) {
                foreach ($request->resources as $resource_id) {
                    array_push($adminResources, ["resource_id" => $resource_id, "admin_id" => $admin->id, 'created_at' => $date, 'updated_at' => $date]);
                }
                AdminResource::insert($adminResources);
            }

            if (!empty($request->permissions)) {
                foreach ($request->permissions as $permission_id) {
                    array_push($adminPermissions, ["permission_id" => $permission_id, "admin_id" => $admin->id, 'created_at' => $date, 'updated_at' => $date]);
                }
                AdminPermission::insert($adminPermissions);
            }

            DB::commit();
            return $admin;
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Add team Api Error";
            return response()->json($e);
        }
    }

    public function updateTeam(Request $request,$id) {
        DB::beginTransaction();
        try {
            $this->validate($request, [
                "name" => "required",
                "email" => "bail|required|email|unique:admins,email,$id",
                "phone_number" => "bail|required|numeric",
            ]);
            $team = Admin::findOrFail($id);
            $team->name = $request->name;
            $team->email = $request->email;
            $team->phone_number = $request->phone_number;
            $team->state = $request->state;
            $team->save();
            $adminRole  = AdminRole::where('admin_id',$id)->update(['role_id'=>$request->role_id]);
            DB::commit();
            return $team;
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Update team Api Error";
            return response()->json($e);
        }
    }

    public function deleteTeam($id) {
        try {
            AdminResource::where('admin_id', $id)->delete();
            AdminPermission::where('admin_id', $id)->delete();
            AdminRole::where('admin_id', $id)->delete();
            return Admin::where('id', $id)->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Team member delete api error";
            return response()->json($e);
        }
    }

    public function updateResourcePermisison(Request $request,$id){
        DB::beginTransaction();
        try {
            $this->validate($request, [
                "resources" => "required",
                "permissions" => "required"
            ]);
            AdminResource::where('admin_id', $id)->delete();
            AdminPermission::where('admin_id', $id)->delete();
            $date = date('Y-m-d h:i:s');
            $adminResources = [];
            $adminPermissions = [];
            if (!empty($request->resources)) {
                foreach ($request->resources as $resource_id) {
                    array_push($adminResources, ["resource_id" => $resource_id, "admin_id" => $id, 'created_at' => $date, 'updated_at' => $date]);
                }
                AdminResource::insert($adminResources);
            }
            if (!empty($request->permissions)) {
                foreach ($request->permissions as $permission_id) {
                    array_push($adminPermissions, ["permission_id" => $permission_id, "admin_id" => $id, 'created_at' => $date, 'updated_at' => $date]);
                }
                AdminPermission::insert($adminPermissions);
            }
            DB::commit();
            return 1;
        } catch (\Illuminate\Database\QueryException $e) {
            $e = "Resources and Permissions update api error";
            return response()->json($e);
        }
    }
}
