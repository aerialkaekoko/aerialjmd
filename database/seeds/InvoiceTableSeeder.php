<?php

use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $invoices= [
            [
                'invoice_code' => 'JMD-001',
                'reference_no' => 'JMD-00001',
                'user_id' => 3,
                'medical_information_id' => 1,
                'due_date' => '2019-12-03',
            ],            

        ];

        Invoice::insert($invoices);
    }
}
