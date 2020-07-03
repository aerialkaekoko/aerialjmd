<?php

use Illuminate\Database\Seeder;
use App\InvoiceDescription;

class InvoiceDescriptionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $invoice_descriptions= [
            [
                'description' => 'Others',               
            ], 
            [
            'description' => 'Medical Expense Fee',               
            ],  
            [
            'description' => 'Japanese Medical Interpreter Fee',               
            ],
            [
            'description' => 'Interpreter & Advance Payment for Medical Expense Fee',                
            ], 
            [
            'description' => 'Case Fee',                
            ], 
            [
            'description' => 'Admission Service Fees',                
            ], 
            [
            'description' => 'Additional Service Fees, Week Days Off Hours', 
                
            ],        
            [
            'description' => 'AdAdditional Service Fees, Weekend & Holidays', 
                
            ],
           
            
            
                  

        ];

        InvoiceDescription::insert($invoice_descriptions);
    }
}
