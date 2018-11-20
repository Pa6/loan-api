<?php

use App\LoanType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoanTypeDBSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('loan_types')->delete();
        LoanType::create(['name' => 'Short loan' , 'description' => 'short loan (within 2 years)']);
        LoanType::create(['name' => 'Medium loan' , 'description' => 'medium loan (within 2-5years)']);
        LoanType::create(['name' => 'Long loan' , 'description' => 'long loan (5 years and above)']);
    }
}
