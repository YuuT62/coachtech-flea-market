<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'user_icon' => 'http://localhost/storage/user-icon/yakiniku.jpg',
            // 'email_verified_at' => new DateTime('2024-01-01'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'role_id' => 2,
            'name' => 'テスト太郎',
            'email' => 'test@example.com',
            'password' => bcrypt('P@ssw0rd'),
            'user_icon' => 'http://localhost/storage/user-icon/yakiniku.jpg',
            // 'email_verified_at' => new DateTime('2024-01-01'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'role_id' => 2,
            'name' => 'テスト次郎',
            'email' => 'test2@example.com',
            'password' => bcrypt('P@ssw0rd'),
            'user_icon' => 'http://localhost/storage/user-icon/yakiniku.jpg',
            // 'email_verified_at' => new DateTime('2024-01-01'),
        ];
        DB::table('users')->insert($param);
    }
}
