<?php
use App\Permission;
use App\User;
use Illuminate\Database\Seeder;

class UserPermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        User::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
    }
}
