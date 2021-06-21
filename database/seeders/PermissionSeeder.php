<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name'  =>   'Add',
                'slug'  =>  'add',
            ],
            [
                'name'  =>   'Update',
                'slug'  =>  'update',
            ],
            [
                'name'  =>   'Delete',
                'slug'  =>  'delete',
            ],
            [
                'name'  =>   'Manage Permission',
                'slug'  =>  'manage_permission',
            ],
        ];
        foreach($permissions as $permission)  {
            Permission::create([
                'name'  =>  $permission['name'],
                'slug'  =>  $permission['slug'],
            ]);
        }
    }
}
