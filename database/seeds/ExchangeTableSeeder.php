<?php
use App\Exchange;

use Illuminate\Database\Seeder;

class ExchangeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $exchanges= [
            [  
                'exchange_usd' => '1',
                'exchange_thb' => '30',
                'exchange_lak' => '9015',
                'exchange_mmk' => '1400',
                'start_date'   => '0',
                'end_date'     => '0',
            ],        

        ];
    Exchange::insert($exchanges);

    }
}
