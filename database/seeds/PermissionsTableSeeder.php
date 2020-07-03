<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [

            [
                
                'title' => 'user_management_access',
                'description' => 'user management access',
            ],
            [
               
                'title' => 'permission_create',
                'description' => 'permission create',
            ],
            [
                
                'title' => 'permission_edit',
                'description' => 'permission edit',
            ],
            [
               
                'title' => 'permission_show',
                'description' => 'permission show',
            ],
            [
                
                'title' => 'permission_delete',
                'description' => 'permission delete',
            ],
            [
                
                'title' => 'permission_access',
                'description' => 'permission access',
            ],
            [
                
                'title' => 'role_create',
                'description' => 'role create',
            ],
            [
                
                'title' => 'role_edit',
                'description' => 'role edit',
            ],
            [
               
                'title' => 'role_show',
                'description' => 'role show',
            ],
            [
               
                'title' => 'role_delete',
                'description' => 'role delete',
            ],
            [
                
                'title' => 'role_access',
                'description' => 'role access',
            ],
            [
               
                'title' => 'user_create',
                'description' => 'user create',
            ],
            [
                
                'title' => 'user_edit',
                'description' => 'user edit',
            ],
            [
               
                'title' => 'user_show',
                'description' => 'user show',
            ],
            [
              
                'title' => 'user_delete',
                'description' => 'user delete',
            ],
            [
                
                'title' => 'user_access',
                'description' => 'user access',
            ],
            
            [
               
                'title' => 'news_create',
                'description' => 'news create',
            ],
            [
                
                'title' => 'news_edit',
                'description' => 'news edit',
            ],
            [
                
                'title' => 'news_show',
                'description' => 'news show',
            ],
            [
                
                'title' => 'news_delete',
                'description' => 'news delete',
            ],
            [
                
                'title' => 'news_access',
                'description' => 'news access',
            ],
            [
                
                'title' => 'setting',
                'description' => 'setting',
            ],
            [
                
                'title' => 'members',
                'description' => 'members access',
            ],
            [
               
                'title' => 'members_create',
                'description' => 'members create',
            ],
            [
                
                'title' => 'members_edit',
                'description' => 'members edit',
            ],
            [
                
                'title' => 'members_show',
                'description' => 'members show',
            ],
            [
                
                'title' => 'members_delete',
                'description' => 'members delete',
            ],
            [
            
                'title' => 'user_alert_create',
                'description' => 'user alert create',
            ],
            [
              
                'title' => 'user_alert_show',
                'description' => 'user alert show',
            ],
            [
               
                'title' => 'user_alert_delete',
                'description' => 'user alert delete',
            ],
            [
              
                'title' => 'user_alert_access',
                'description' => 'user alert access',
            ],
            [
                'title' => 'claim_create',
                'description' => 'claim create',
            ],
            [
                'title' => 'claim_edit',
                'description' => 'claim edit',
            ],
            [
                'title' => 'claim_show',
                'description' => 'claim show',
            ],
            [
                'title' => 'claim_delete',
                'description' => 'claim delete',
            ],
            [
                'title' => 'claim_access',
                'description' => 'claim access',
            ],
            [
                'title' => 'claim_download',
                'description' => 'claim download',
            ],
            [
                'title' => 'hospitals_create',
                'description' => 'hospitals create',
            ],
            [
                'title' => 'hospitals_edit',
                'description' => 'hospitals edit',
            ],
            [
                'title' => 'hospitals_show',
                'description' => 'hospitals show',
            ],
            [
                'title' => 'hospitals_delete',
                'description' => 'hospitals delete',
            ],
            [
                'title' => 'hospitals_access',
                'description' => 'hospitals access',
            ],
            [
                'title' => 'doctors_create',
                'description' => 'doctors create',
            ],
            [
                'title' => 'doctors_edit',
                'description' => 'doctors edit',
            ],
            [
                'title' => 'doctors_show',
                'description' => 'doctors show',
            ],
            [
                'title' => 'doctors_delete',
                'description' => 'doctors delete',
            ],
            [
                'title' => 'doctors_access',
                'description' => 'doctors access',
            ],
            [
                'title' => 'exchanges_create',
                'description' => 'exchanges create',
            ],
            [
                'title' => 'exchanges_edit',
                'description' => 'exchanges edit',
            ],
            [
                'title' => 'exchanges_show',
                'description' => 'exchanges show',
            ],
            [
                'title' => 'exchanges_delete',
                'description' => 'exchanges delete',
            ],
            [
                'title' => 'exchanges_access',
                'description' => 'exchangesaccess',
            ],

            [
                'title' => 'expenses_create',
                'description' => 'expenses create',
            ],
            [
                'title' => 'expenses_edit',
                'description' => 'expenses edit',
            ],
            [
                'title' => 'expenses_show',
                'description' => 'expenses show',
            ],
            [
                'title' => 'expenses_delete',
                'description' => 'expenses delete',
            ],
            [
                'title' => 'expenses_access',
                'description' => 'expensesaccess',
            ],

            [
                'title' => 'medicals_create',
                'description' => 'medicals create',
            ],
            [
                'title' => 'medicals_edit',
                'description' => 'medicals edit',
            ],
            [
                'title' => 'medicals_show',
                'description' => 'medicals show',
            ],
            [
                'title' => 'medicals_delete',
                'description' => 'medicals delete',
            ],
            [
                'title' => 'medicals_access',
                'description' => 'medicals access',
            ],
            [
                'title' => 'assistance_create',
                'description' => 'assistance create',
            ],
            [
                'title' => 'assistance_edit',
                'description' => 'assistance edit',
            ],
            [
                'title' => 'assistance_show',
                'description' => 'assistance show',
            ],
            [
                'title' => 'assistance_delete',
                'description' => 'assistance delete',
            ],
            [
                'title' => 'assistance_access',
                'description' => 'assistance access',
            ],
              [
                'title' => 'insurance_create',
                'description' => 'insurance create',
            ],
            [
                'title' => 'insurance_edit',
                'description' => 'insurance edit',
            ],
            [
                'title' => 'insurance_show',
                'description' => 'insurance show',
            ],
            [
                'title' => 'insurance_delete',
                'description' => 'insurance delete',
            ],
            [
                'title' => 'insurance_access',
                'description' => 'insurance access',
            ],
            [
                'title' => 'user_insurance_create',
                'description' => 'user insurance create',
            ],
            [
                'title' => 'user_insurance_edit',
                'description' => 'user insurance edit',
            ],
            [
                'title' => 'user_insurance_show',
                'description' => 'user insurance show',
            ],
            [
                'title' => 'user_insurance_delete',
                'description' => 'user insurance delete',
            ],
            [
                'title' => 'user_insurance_access',
                'description' => 'user insurance access',
            ],            
            [
                'title' => 'invoice_create',
                'description' => 'invoice create',
            ],
            [
                'title' => 'invoice_edit',
                'description' => 'invoice edit',
            ],
            [
                'title' => 'invoice_show',
                'description' => 'invoice show',
            ],
            [
                'title' => 'invoice_delete',
                'description' => 'invoice delete',
            ],
            [
                'title' => 'invoice_access',
                'description' => 'invoice access',
            ],
            [
                'title' => 'invoice_download',
                'description' => 'invoice download',
            ],
              [
                'title' => 'fileshare',
                'description' => 'fileshare',
            ],
            [
                'title' => 'insurance_info',
                'description' => 'insurance info',
            ],
            [
                'title' => 'medical_info',
                'description' => 'medical info',
            ],
            [
                'title' => 'medical_informations_create',
                'description' => 'medical informations create',
            ],
            [
                'title' => 'medical_informations_edit',
                'description' => 'medical informations edit',
            ],
            [
                'title' => 'medical_informations_show',
                'description' => 'medical informations show',
            ],
            [
                'title' => 'medical_informations_delete',
                'description' => 'medical informations delete',
            ],
            [
                'title' => 'medical_informations_access',
                'description' => 'medical informations access',
            ],
            [
                'title' => 'personal_informations_create',
                'description' => 'personal informations create',
            ],
            [
                'title' => 'personal_informations_edit',
                'description' => 'personal informations edit',
            ],
            [
                'title' => 'personal_informations_show',
                'description' => 'personal informations show',
            ],
            [
                'title' => 'personal_informations_delete',
                'description' => 'personal informations delete',
            ],
            [
                'title' => 'personal_informations_access',
                'description' => 'personal informations access',
            ],
            [
                'title' => 'report_access',
                'description' => 'report access',
            ],
             [
                'title' => 'admin_dashboard',
                'description' => 'admin dashboard',
            ],
            [
                'title' => 'messages_access',
                'description' => 'Messages',
            ],
            [
                'title' => 'membership_create',
                'description' => 'membership create',
            ],
            [
                'title' => 'membership_edit',
                'description' => 'membership edit',
            ],
            [
                'title' => 'membership_show',
                'description' => 'membership show',
            ],
            [
                'title' => 'membership_delete',
                'description' => 'membership delete',
            ],
            [
                'title' => 'membership_access',
                'description' => 'membership access',
            ],
            [
                'title' => 'local_insurance_create',
                'description' => 'local_insurance create',
            ],
            [
                'title' => 'local_insurance_edit',
                'description' => 'local_insurance edit',
            ],
            [
                'title' => 'local_insurance_show',
                'description' => 'local_insurance show',
            ],
            [
                'title' => 'local_insurance_delete',
                'description' => 'local_insurance delete',
            ],
            [
                'title' => 'local_insurance_access',
                'description' => 'local_insurance access',
            ],
            [
                'title' => 'department_create',
                'description' => 'department create',
            ],
            [
                'title' => 'department_edit',
                'description' => 'department edit',
            ],
            [
                'title' => 'department_show',
                'description' => 'department show',
            ],
            [
                'title' => 'department_delete',
                'description' => 'department delete',
            ],
            [
                'title' => 'department_access',
                'description' => 'department access',
            ],
            [
                'title' => 'invoice_description_create',
                'description' => 'invoice_description create',
            ],
            [
                'title' => 'invoice_description_edit',
                'description' => 'invoice_description edit',
            ],
            [
                'title' => 'invoice_description_show',
                'description' => 'invoice_description show',
            ],
            [
                'title' => 'invoice_description_delete',
                'description' => 'invoice_description delete',
            ],
            [
                'title' => 'invoice_description_access',
                'description' => 'invoice_description access',
            ],
        
        ];
        Permission::insert($permissions);
    }
}
