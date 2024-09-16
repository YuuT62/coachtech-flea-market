<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 2,
            'item_id' => 1,
            'comment' => "あいうえおかくけこさしすせそたちつてとなにぬねのはひふへほまみむめも",
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 1,
            'comment' => "あいうえおかくけこさしすせそたちつてとなにぬねのはひふへほまみむめも",
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 2,
            'item_id' => 1,
            'comment' => "0123456789",
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 1,
            'comment' => "0123456789",
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 2,
            'item_id' => 1,
            'comment' => "abcdefghijklmnopqrstuvwxyz",
        ];
        DB::table('comments')->insert($param);

        $param = [
            'user_id' => 3,
            'item_id' => 1,
            'comment' => "abcdefghijklmnopqrstuvwxyz",
        ];
        DB::table('comments')->insert($param);
    }
}
