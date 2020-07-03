<?php

use Illuminate\Database\Seeder;
use App\Membership;

class MembershipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $memberships= [
            [
                'company_name' => 'WellBe',
                'membership_short_code' => 'WEB',
            ],     
            [
                'company_name' => 'Prestage Healthcare',
                'membership_short_code' => 'PSI',
            ], 

        ];

    Membership::insert($memberships);
    }
}
