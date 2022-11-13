<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::firstOrCreate([
            'id' => 1,
            'username' => 'teacher1',
            'password' => Hash::make('123456a@A'),
            'role_id' => 1,
            'owner_id' => null,
            'full_name' => null,
            'email' => null,
            'phone' => null,
            'avatar' => null,
            'url' => null,
            'is_active' => 1,
        ]);
        User::firstOrCreate([
            'id' => 2,
            'username' => 'teacher2',
            'password' => Hash::make('123456a@A'),
            'role_id' => 1,
            'owner_id' => 1,
            'full_name' => null,
            'email' => null,
            'phone' => null,
            'avatar' => null,
            'url' => null,
            'is_active' => 1,
        ]);
        User::firstOrCreate([
            'id' => 3,
            'username' => 'student1',
            'password' => Hash::make('123456a@A'),
            'role_id' => 2,
            'owner_id' => 1,
            'full_name' => null,
            'email' => null,
            'phone' => null,
            'avatar' => null,
            'url' => null,
            'is_active' => 1,
        ]);
        User::firstOrCreate([
            'id' => 4,
            'username' => 'student2',
            'password' => Hash::make('123456a@A'),
            'role_id' => 2,
            'owner_id' => 1,
            'full_name' => null,
            'email' => null,
            'phone' => null,
            'avatar' => null,
            'url' => null,
            'is_active' => 1,
        ]);
    }
}
