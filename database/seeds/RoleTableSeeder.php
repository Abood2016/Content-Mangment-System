<?php

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();


        $adminRole = Role::create([

            'name' => 'admin',
            'display_name' => 'adminstrator',
            'description' => 'system admin',
            'allowed_route' => 'admin',

        ]);
        $editorRole = Role::create([
            'name' => 'editor',
            'display_name' => 'editor',
            'description' => 'system editor',
            'allowed_route' => 'admin',

        ]);
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'user',
            'description' => 'normal user',
            'allowed_route' => null,

        ]);

        $admin = User::create([
            'name' => 'editor',
            'username' => 'editor',
            'email' => 'editor@gmail.com',
            'mobile' => "0592663575",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(12345678),
            'status' => 1,

        ]);

        $admin->attachRole($adminRole);


        $editor = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'mobile' => "0592663574",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(12345678),
            'status' => 1,

        ]);
        $editor->attachRole($editorRole);


        $user = User::create([
            'name' => 'AbedEl Rahman',
            'username' => 'Abed',
            'email' => 'abed@gmail.com',
            'mobile' => "0592663578",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(12345678),
            'status' => 1,

        ]);
        $user->attachRole($userRole);

        $user2 = User::create([
            'name' => 'Ahmed',
            'username' => 'Ahmed',
            'email' => 'Ahmed@gmail.com',
            'mobile' => "0595663578",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(12345678),
            'status' => 1,

        ]);
        $user2->attachRole($userRole);

        $user3 = User::create([
            'name' => 'mahmmoud',
            'username' => 'mahmmoud',
            'email' => 'mahmmoud@gmail.com',
            'mobile' => "025956363578",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(12345678),
            'status' => 1,

        ]);
        $user3->attachRole($userRole);

        $user4 = User::create([
            'name' => 'ali',
            'username' => 'ali',
            'email' => 'ali@gmail.com',
            'mobile' => "05956363578",
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt(12345678),
            'status' => 1,

        ]);
        $user4->attachRole($userRole);


        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'username' => $faker->username,
                'email' => $faker->email,
                'mobile' => '059' . random_int(10000, 99999999),
                'password' => bcrypt('12345678'),
                'status' => 1,

            ]);
            $user->attachRole($userRole);
        }

    }
}
