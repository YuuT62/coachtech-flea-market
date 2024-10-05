<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'item_id' => 1,
            'category_id' => 1,
        ];
        DB::table('category_items')->insert($param);

        $param = [
            'item_id' => 1,
            'category_id' => 2,
        ];
        DB::table('category_items')->insert($param);

        $param = [
            'item_id' => 2,
            'category_id' => 3,
        ];
        DB::table('category_items')->insert($param);
    }
}
