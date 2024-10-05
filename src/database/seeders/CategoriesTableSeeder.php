<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category' => '洋服',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'category' => '男性',
        ];
        DB::table('categories')->insert($param);

        $param = [
            'category' => '女性',
        ];
        DB::table('categories')->insert($param);
    }
}
