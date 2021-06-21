<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins =[
            [
                'name'  =>  'Super Admin',
                'email'=>'superadmin@test.com',
                'phone_number'=>'0123456789',
                'password'=>123456
            ],
        ];

        foreach($admins as $admin) {
            Admin::create([
                'name'  =>  $admin['name'],
                'email' =>  $admin['email'],
                'phone_number' =>  $admin['phone_number'],
                'password'  =>  Hash::make($admin['password']),
                'state' =>  1
            ]);
        }
    }
}
