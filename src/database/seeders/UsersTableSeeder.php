<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'role_id' => 1,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('P@ssw0rd'),
            'user_icon' => '',
            'created_at' => new DateTime('2024-01-01'),
        ];
        DB::table('users')->insert($param);

    }
}
