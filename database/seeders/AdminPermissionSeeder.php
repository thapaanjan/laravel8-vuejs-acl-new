<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Admin;
use App\Models\AdminPermission;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $admin = Admin::first();
        foreach($permissions as $permission) {
            AdminPermission::create([
                'permission_id' =>    $permission->id,
                'admin_id'  =>  $admin->id,
            ]);            
        }
    }
}
