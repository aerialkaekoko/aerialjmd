<?php
use App\Medical;

use Illuminate\Database\Seeder;

class MedicalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $medicals= [
            [
                
                'disease_name' => 'Ischemic heart disease',
                'manufacturer' => 'Manufacturer',
                'hospital_id' => '1',
                'doctor_id' => '1',
                'user_id' => '1',
            ],
            [                
                'disease_name' => 'Ischemic heart disease',
                'manufacturer' => 'Manufacturer',
                'hospital_id' => '2',
                'doctor_id' => '2',
                'user_id' => '1',                
                
            ],
            [                
                'disease_name' => 'Ischemic heart disease',
                'manufacturer' => 'Manufacturer',
                'hospital_id' => '2',
                'doctor_id' => '2',
                'user_id' => '1',               
                
            ],           

        ];

    Medical::insert($medicals);

    }
}
