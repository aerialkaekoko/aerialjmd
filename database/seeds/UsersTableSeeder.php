<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id' => 1,
                'family_name' => 'fadmin',
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => '$2y$10$FjcfuoUC/XDrbI.zaaV9ZuDDgOF5tu0VaZeFODubHqdQ793N8PL2y',
                'address_current' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,Yangon,Myanmar',
                'gender' => 'male',
                'passport' => 'asdfsa345254',
                'address' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,tokyo,japan',
                'Phone' => '+09123412341234',
                'remember_token' => null,
                'approved' => 1,
                'verified' => 1,
                'verified_at' => '2019-10-29 08:33:45',
                'verification_token' => '',
            ],
            [
                'id' => 2,
                'family_name' => 'fuser',
                'name' => 'user',
                'email' => 'user@user.com',
                'password' => '$2y$10$FjcfuoUC/XDrbI.zaaV9ZuDDgOF5tu0VaZeFODubHqdQ793N8PL2y',
                'address_current' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,Yangon,Myanmar',
                'gender' => 'female',
                'passport' => 'asdfsa345254',
                'address' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,tokyo,japan',
                'Phone' => '+09123412341234',
                'remember_token' => null,
                'approved' => 1,
                'verified' => 1,
                'verified_at' => '2019-10-29 08:33:45',
                'verification_token' => '',
            ],
            [
                'id' => 3,
                'family_name' => 'John',
                'name' => 'Doe',
                'email' => 'member@member.com',
                'password' => '$2y$10$FjcfuoUC/XDrbI.zaaV9ZuDDgOF5tu0VaZeFODubHqdQ793N8PL2y',
                'gender' => 'male',
                'passport' => 'MD-354350',
                'address' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,tokyo,japan',
                'address_current' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,Yangon,Myanmar',
                'Phone' => '+09123412341234',
                'remember_token' => null,
                'approved' => 1,
                'verified' => 1,
                'verified_at' => '2019-10-29 08:33:45',
                'verification_token' => '',
            ],
             [
                'id' => 4,
                'family_name' => 'Kyaw',
                'name' => 'Min thu',
                'email' => 'kyawminthu@member.com',
                'password' => '$2y$10$FjcfuoUC/XDrbI.zaaV9ZuDDgOF5tu0VaZeFODubHqdQ793N8PL2y',
                'gender' => 'male',
                'passport' => 'MD-394750',
                'address' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,tokyo,japan',
                'address_current' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,Yangon,Myanmar',
                'Phone' => '+091232341234',
                'remember_token' => null,
                'approved' => 1,
                'verified' => 1,
                'verified_at' => '2019-10-29 08:33:45',
                'verification_token' => '',
            ],
            [
                'id' => 5,
                'family_name' => 'Myo',
                'name' => 'Ko',
                'email' => 'myoko@member.com',
                'password' => '$2y$10$FjcfuoUC/XDrbI.zaaV9ZuDDgOF5tu0VaZeFODubHqdQ793N8PL2y',
                'gender' => 'male',
                'passport' => 'MD-123232',
                'address' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,tokyo,japan',
                'address_current' => 'No.21,5th Floor , Hin Tha Da Street Sanchaung Township,Yangon,Myanmar',
                'Phone' => '+091232341234',
                'remember_token' => null,
                'approved' => 1,
                'verified' => 1,
                'verified_at' => '2019-10-29 08:33:45',
                'verification_token' => '',
            ],
        ];

        User::insert($users);
    }
}
