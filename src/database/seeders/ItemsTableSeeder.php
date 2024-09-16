<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($a=1; $a<=5; $a++){
        $param = [
            'user_id' => 2,
            'item_name' => 'テスト商品',
            'price' => 1000,
            'brand_name' => 'test',
            'description' => 'あいうえおかくけこさしすせそたちつてとなにぬねのはひふへほまみむめもやゆよらりるれろわをん',
            'condition_id' => 1,
            'item_img' => 'http://localhost/storage/img/yakiniku.jpg',
        ];
        DB::table('items')->insert($param);
        }
    }
}
