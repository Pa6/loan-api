<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(LaratrustSeeder::class);
         $this->call(InterestRateDBSeeder::class);
         $this->call(LoanTypeDBSeeder::class);
         $this->call(PaymentTypeDBSeeder::class);
    }
}
