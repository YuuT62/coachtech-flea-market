<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'payment_method' => 'クレジットカード払い',
        ];
        DB::table('payment_methods')->insert($param);

        $param =[
            'payment_method' => 'コンビニ払い',
        ];
        DB::table('payment_methods')->insert($param);
        $param =[
            'payment_method' => '銀行振込',
        ];
        DB::table('payment_methods')->insert($param);

    }
}
