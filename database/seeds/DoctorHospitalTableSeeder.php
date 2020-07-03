<?php

use App\Doctor;
use Illuminate\Database\Seeder;

class DoctorHospitalTableSeeder extends Seeder
{
    public function run()
    {
        Doctor::findOrFail(1)->hospitals()->sync(1);
        Doctor::findOrFail(2)->hospitals()->sync(2);
        Doctor::findOrFail(3)->hospitals()->sync(3);
    }
}
