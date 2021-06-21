<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminRole;
use App\Models\Role;
use App\Models\Admin;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::first();
        $role = Role::first();
        AdminRole::create([
            'role_id'   =>  $role->id,
            'admin_id'  =>  $admin->id,
        ]);
    }
}

