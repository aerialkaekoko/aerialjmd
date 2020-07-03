<?php

use Illuminate\Database\Seeder;
use App\Assistance;

class AssistancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $assistances= [
            [
                'assistance_name' => 'PI',
                'short_code' => 'PI',
                'to_name' => 'PIPRESTIGE INTERNATIONAL (S) PTE LTD',
                'email' => 'tm@gmail.com',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'insurance_id' => 1,
            ],        
            [
                'assistance_name' => 'ISOS',
                'short_code' => 'ISOS',
                'to_name' => 'INTERNATIONAL SOS SERVICES (THAILAND)',
                'email' => 'tm@gmail.com',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'insurance_id' => 2,
            ],        
            [
                'assistance_name' => 'INTAC',
                'short_code' => 'INTAC',
                'to_name' => 'Inter Partner Assistance Co., Ltd.',
                'email' => 'tm@gmail.com',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'insurance_id' => 3,
            ],        
            [
                'assistance_name' => 'EAJ',
                'short_code' => 'EAJ',
                'to_name' => 'Emergency Assistance Japan Co., Ltd.',
                'email' => 'tm@gmail.com',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'insurance_id' => 4,
            ],        
            [
                'assistance_name' => 'AXA',
                'short_code' => 'AXA',
                'to_name' => 'AXA Assistance Japan',
                'email' => 'tm@gmail.com',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'insurance_id' => 5,
            ],        
            [
                'assistance_name' => 'AWP',
                'short_code' => 'AWP',
                'to_name' => 'AWP Services (Thailand) Co.,Ltd.',
                'email' => 'tm@gmail.com',
                'phone' => '0938383838',
                'address' => 'Tokyo',
                'insurance_id' => 6,
            ],         

        ];

    Assistance::insert($assistances);
    }
}
