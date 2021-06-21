<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\AdminResource;
use App\Models\Admin;

class AdminResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $resources = Resource::all();
        $admin = Admin::first();
        foreach($resources as $resource) {
            AdminResource::create([
                'resource_id' =>    $resource->id,
                'admin_id'  =>  $admin->id,
            ]);            
        }
    }
}
