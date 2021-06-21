<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles =[
            [
                'name'  =>  'Super Admin',
                'slug'  =>  'super_admin',
                'description'   =>'Manages super admin privileges'
            ]
        ];

        foreach($roles as $role) {
            Role::create([
                'name'  =>  $role['name'],
                'slug'  =>  $role['slug'],
                'description'   =>  $role['description']
            ]);
        }
    }
}
