<?php
use App\Expense;

use Illuminate\Database\Seeder;

class ExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $expenses= [
            [  
                'staff_one'     => '0',
                'staff_two'     => '0',
                'staff_three'   => '0',
                'other_expense' => '0',
            ],        

        ];
    Expense::insert($expenses);

    }
}
