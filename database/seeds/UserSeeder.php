<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUser = new Role();
        $roleUser->name = "ROLE_USER";
        $roleUser->save();

        $roleAdmin = new Role();
        $roleAdmin->name = "ROLE_ADMIN";
        $roleAdmin->save();

        $user = new User();
        $user->name = "Administrator";
        $user->email = "admin@gmail.com";
        $user->password = Hash::make("admin");
        $user->api_token = Str::random(60);
        $user->save();
        $user->roles()->attach($roleAdmin->id);
    }
}
