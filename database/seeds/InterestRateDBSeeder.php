<?php

use App\InterestType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InterestRateDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('interest_types')->delete();
        InterestType::create(['name' => 'Simple interest' , 'description' => 'simple interest']);
        InterestType::create(['name' => 'Compound interest' , 'description' => 'compound interest']);
    }
}
