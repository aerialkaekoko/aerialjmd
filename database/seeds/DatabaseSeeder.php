<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            NewsTableSeeder::class,
            MediaTableSeeder::class,
            HospitalTableSeeder::class,
            DoctorTableSeeder::class,
            DoctorHospitalTableSeeder::class,            
            MedicalTableSeeder::class,
            SettingsTableSeeder::class,
            InsurancesTableSeeder::class,
            AssistancesTableSeeder::class,
            UserInsurancesTableSeeder::class,
            // MedicalInformationTableSeeder::class,
            // InvoiceTableSeeder::class,
            UserPermissionTableSeeder::class,
            ExchangeTableSeeder::class,
            MembershipTableSeeder::class,
            InvoiceDescriptionTableSeeder::class,
        ]);
    }
}
