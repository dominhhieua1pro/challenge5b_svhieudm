<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'id' => '1', 'role_name' => 'Teacher'
        ]);
        Role::firstOrCreate([
            'id'=> '2', 'role_name' => 'Student'
        ]);
    }
}
