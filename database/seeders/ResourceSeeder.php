<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = [
            [
                'name'  =>   'Dashboard',
                'slug'  =>  'dashboard',
            ],
            [
                'name'  =>   'Resources',
                'slug'  =>  'resources',
            ],
            [
                'name'  =>   'Users',
                'slug'  =>  'users',
            ],
            [
                'name'  =>   'Teams',
                'slug'  =>  'teams',
            ],
            [
                'name'  =>   'Roles',
                'slug'  =>  'roles',
            ]
        ];

        foreach($resources as $resource)  {
            Resource::create([
                'name'  =>  $resource['name'],
                'slug'  =>  $resource['slug'],
            ]);
        }
    }
}
