<?php

use Illuminate\Database\Seeder;
use App\Insurance;

class InsurancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $insurances= [
            [
                'company_name' => 'Aioi',                
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AIG',
                'template' => 'templateone',  
                
            ],        
            [
                'company_name' => 'AIG',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'SOMPO',
                'template' => 'templatetwo', 
                
            ],
            [
                'company_name' => 'Nissin',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templateseven', 
                
            ],
             [
                'company_name' => 'Mitsui',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templateeight', 
                
            ],
             [
                'company_name' => 'HS',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templatefour', 
                
            ],
            [
                'company_name' => 'JI',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templatethree', 
                
            ],
            [
                'company_name' => 'Sompo',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templatefive', 
                
            ],
            [
                'company_name' => 'Tokio',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templatesix', 
                
            ], 
            [
                'company_name' => 'Asahi',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'style' => 'AON',
                'template' => 'templateone', 
                
            ],                 

        ];

        Insurance::insert($insurances);
    }
}
