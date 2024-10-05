<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PayMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'condition' => '新品・未使用',
        ];
        DB::table('conditions')->insert($param);

        $params = [
            'payment_'
        ]
    }
}
