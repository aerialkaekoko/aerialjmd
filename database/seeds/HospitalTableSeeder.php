<?php
use App\Hospital;

use Illuminate\Database\Seeder;

class HospitalTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $hospitals= [
            [
                
                'name' => 'Parami Hospital',
                'country' => 1,
                'country_code' => 'M',
                'address' => 'Sanchaung, Myanmar',
                'contact' => '0809045',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
            ],
            [                
                'name' => 'Prachinburi',
                'country' => 2,
                'country_code' => 'P',
                'address' => '61/4 Sukhumvit Soi 1, Klongtoey-nua, Wattana, Bangkok, Thailand',
                'contact' => '0809045',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                
                
            ],
            [                
                'name' => 'Ayutthaya',
                'country' => 2,
                'country_code' => 'A',
                'address' => 'Địa chỉ: 40 Phố Tràng Thi - Hà Nội - Việt Nam',
                'contact' => '0809045',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',                
                
            ],          

        ];

    Hospital::insert($hospitals);

    }
}
