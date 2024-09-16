<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 関東
        $param = [
            'prefecture' => '茨城県',
        ];
        DB::table('prefectures')->insert($param);
        $param = [
            'prefecture' => '栃木県',
        ];
        DB::table('prefectures')->insert($param);
        $param = [
            'prefecture' => '群馬県',
        ];
        DB::table('prefectures')->insert($param);
        $param = [
            'prefecture' => '埼玉県',
        ];
        DB::table('prefectures')->insert($param);
        $param = [
            'prefecture' => '千葉県',
        ];
        DB::table('prefectures')->insert($param);
        $param = [
            'prefecture' => '東京都',
        ];
        DB::table('prefectures')->insert($param);
        $param = [
            'prefecture' => '神奈川県',
        ];
        DB::table('prefectures')->insert($param);
    }
}
