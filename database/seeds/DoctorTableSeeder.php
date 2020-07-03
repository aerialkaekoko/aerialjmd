<?php
use App\Doctor;

use Illuminate\Database\Seeder;

class DoctorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $doctors= [
            [
                
                'name' => 'Michael Carrick',
                'specialist' => 'Anesthesiologists',
                'qualification' => 'M.B.,B.S, M.Med.Sc (Int.Med)',
                'schedule' => 'Tue, Thu -11:00 AM to 10:00 PM',
                'country' => 'Myanmar',
                'contact' => '0809045',
                'address' => 'Sanchaung, Myanmar',
            ],
            [                
                'name' => 'Paul Scholes',
                'specialist' => 'Immunologists',
                'qualification' => 'M.B.,B.S, M.Med.Sc (Int.Med)',
                'schedule' => 'Tue, Thu -11:00 AM to 10:00 PM',
                'country' => 'Thailand',
                'contact' => '0809045',
                'address' => 'Sanchaung, Myanmar',                
                
            ],
            [                
                'name' => 'Wayne Rooney',
                'specialist' => 'Cardiologists',
                'qualification' => 'M.B.,B.S, M.Med.Sc (Int.Med)',
                'schedule' => 'Tue, Thu -11:00 AM to 10:00 PM',
                'country' => 'Vietnam',
                'contact' => '0809045',
                'address' => 'Sanchaung, Myanmar',                
                
            ],           

        ];

    Doctor::insert($doctors);

    }
}
