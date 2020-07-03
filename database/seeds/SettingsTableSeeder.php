<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert(
            [
                'name' => 'app_name',
                'val' => 'JMD WEB APPP',
            ]
          );
          DB::table('settings')->insert(
                [
                    'name' => 'logo',
                    'val' => 'hKkPZduTAeuupGbFWIKUNwkaJTMbxyKOBzeqTT2U.png',
                ]
            );

        DB::table('settings')->insert(
            [
                'name' => 'banner',
                'val' => '',
            ]
        );
        DB::table('settings')->insert(
            [
                'name' => 'background',
                'val' => '',
            ]
        );

        DB::table('settings')->insert(
            [
                'name' => 'address',
                'val' => 'No. 10/A, 1st Floor, Zambutheingi St, Bo Kan Nyunt Qt, Thingangyun Tsp, Yangon, Union of Myanmar.',
            ]
        );

        DB::table('settings')->insert(
            [
                'name' => 'jmd_email',
                'val' => 'admin@admin.com',
            ]
        );

        DB::table('settings')->insert(
            [
                'name' => 'phone',
                'val' => '23412341234124',
            ]
        );
        DB::table('settings')->insert(
            [
                'name' => 'from_email',
                'val' => 'admin@admin.com',
            ]
        );

    

    }
}
