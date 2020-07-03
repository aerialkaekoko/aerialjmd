<?php

use Illuminate\Database\Seeder;

class MedicalInformationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medical_infos= [
            [
                'user_id' => 3,
                'hospital_id' => 1,
                'medical_id' => 1,
                'receive_type' => 1,
                'insurance_id' => 1,
                'medical_amount' => 100,
            ],            

        ];

        MedicalInformation::insert($medical_infos);
    }
}
