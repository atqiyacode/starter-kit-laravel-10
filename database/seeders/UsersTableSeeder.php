<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Superadmin user

        $user = User::create([
            'username' => 'superadmin',
            'name' => 'Super Admin',
            'email' => 'atqiya@atqiyacode.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Bind superadmin user to FilamentShield
        // Artisan::call('shield:super-admin', ['--user' => $user->id]);

        $data_users = [];

        for ($i = 1; $i < 5; $i++) {
            $data_users[] = [
                'username' => $faker->unique()->userName,
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('users')->insert($data_users);

        $roles = DB::table('roles')->whereNot('name', 'super_admin')->get()->pluck('id')->toArray();
        $members = User::whereNot('username', 'superadmin')->get();
        foreach ($members as $member) {
            $member->assignRole([$roles]);
        }
    }
}
