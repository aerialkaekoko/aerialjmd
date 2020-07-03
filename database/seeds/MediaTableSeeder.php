<?php

use Illuminate\Database\Seeder;

class MediaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('media')->insert(
            [
                
                'model_type' => 'App\News',
                'model_id' => 5,
                'name' => '5db2aa16c4edc_Myanmar3_Unicode_keyboard_Layout',
                'collection_name'=>"news_images",
                'file_name' => '5db2aa16c4edc_Myanmar3_Unicode_keyboard_Layout.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'size' => 125270,
                'manipulations' => '[]',
                'custom_properties' => '{"generated_conversions":{"thumb":true}}',
                'responsive_images' => '[]',
                'order_column' => 1
                

            ]);
         DB::table('media')->insert(
             [
                
                'model_type' => 'App\News',
                'model_id' => 4,
                'name' => '5db2ab68f35b1_Bagan',
                'collection_name'=>"news_images",
                'file_name' => '5db2ab68f35b1_Bagan.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'size' => 206533,
                'manipulations' => '[]',
                'custom_properties' => '{"generated_conversions":{"thumb":true}}',
                'responsive_images' => '[]',
                'order_column' => 2
                

             ]);
              DB::table('media')->insert(
             [
                
                'model_type' => 'App\News',
                'model_id' => 3,
                'name' => '5db2ab92d0ac7_KYAINGTONG',
                'collection_name'=>"news_images",
                'file_name' => '5db2ab92d0ac7_KYAINGTONG.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'size' => 282880,
                'manipulations' => '[]',
                'custom_properties' => '{"generated_conversions":{"thumb":true}}',
                'responsive_images' => '[]',
                'order_column' => 3
                

             ]);
              DB::table('media')->insert(
             [
                
                'model_type' => 'App\News',
                'model_id' => 2,
                'name' => '5db2ab9eb2247_Mandalay',
                'collection_name'=>"news_images",
                'file_name' => '5db2ab9eb2247_Mandalay.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'size' => 168484,
                'manipulations' => '[]',
                'custom_properties' => '{"generated_conversions":{"thumb":true}}',
                'responsive_images' => '[]',
                'order_column' => 4
                

             ]);
              DB::table('media')->insert(
             [
                
                'model_type' => 'App\News',
                'model_id' => 1,
                'name' => '5db2abaa3938b_Sittwe,_Burma',
                'collection_name'=>"news_images",
                'file_name' => '5db2abaa3938b_Sittwe,_Burma.jpg',
                'mime_type' => 'image/jpeg',
                'disk' => 'public',
                'size' => 200614,
                'manipulations' => '[]',
                'custom_properties' => '{"generated_conversions":{"thumb":true}}',
                'responsive_images' => '[]',
                'order_column' => 5
                

             ]);

             DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 1,
                'name' => '5e1556ac97d79_Aioi_Nissay_Dowa',
                'collection_name'=>"template_pdf",
                'file_name' => '5e1556ac97d79_Aioi_Nissay_Dowa.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 276535,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 6
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 2,
                'name' => '5e1556a28d5e2_AIU',
                'collection_name'=>"template_pdf",
                'file_name' => '5e1556a28d5e2_AIU.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 285250,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 7
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 3,
                'name' => '5e155695a2cff_DOCS_NISSIN_CF',
                'collection_name'=>"template_pdf",
                'file_name' => '5e155695a2cff_DOCS_NISSIN_CF.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 261567,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 8
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 4,
                'name' => '5e15567f93e02_kyoei_fire_marine',
                'collection_name'=>"template_pdf",
                'file_name' => '5e15567f93e02_kyoei_fire_marine.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 123831,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 9
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 5,
                'name' => '5e15568c15d47_HS_Insurance',
                'collection_name'=>"template_pdf",
                'file_name' => '5e15568c15d47_HS_Insurance.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 184328,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 10
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 6,
                'name' => '5e155676edb90_Prestige_International',
                'collection_name'=>"template_pdf",
                'file_name' => '5e155676edb90_Prestige_International.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 339857,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 11
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 7,
                'name' => '5e15566c1e613_Sompo_Japan',
                'collection_name'=>"template_pdf",
                'file_name' => '5e15566c1e613_Sompo_Japan.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 140441,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 12
                

             ]

            );
            DB::table('media')->insert(
             [
                
                'model_type' => 'App\Insurance',
                'model_id' => 8,
                'name' => '5e1556620c922_TOKYO_MARIN',
                'collection_name'=>"template_pdf",
                'file_name' => '5e1556620c922_TOKYO_MARIN.pdf',
                'mime_type' => 'application/pdf',
                'disk' => 'public',
                'size' => 4759941,
                'manipulations' => '[]',
                'custom_properties' => '[]',
                'responsive_images' => '[]',
                'order_column' => 13
                

             ]

            );
    
 }
}
