<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create an admin user
        if(config('mint.admin_email') == null) return;
        $adminUser = User::create([
            'name' => config('mint.admin_name'),
            'username' => config('mint.admin_username'),
            'email' => config('mint.admin_email'),
            'password' => Hash::make(config('mint.admin_password'))
        ]);

        $adminRole = Role::where(['name' => 'admin'])->first();
        if(isset($adminRole)) {
            $adminUser->assignRole($adminRole);
        }


    }
}
