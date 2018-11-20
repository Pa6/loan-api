<?php

use App\PaymentType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentTypeDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_types')->delete();
        PaymentType::create(['name' => 'cash' , 'description' => 'cash']);
        PaymentType::create(['name' => 'visa and mastercard' , 'description' => 'visa and mastercard']);
    }
}
