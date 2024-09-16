<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'score' => 100,
        ];
        DB::table('roles')->insert($param);

        $param = [
            'score' => 1,
        ];
        DB::table('roles')->insert($param);
    }
}
