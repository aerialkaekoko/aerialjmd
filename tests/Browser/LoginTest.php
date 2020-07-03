<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**@test */
    public function test_a_user_can_login()
    {
         $this->browse(function (Browser $browser) {
           $browser->visit('/login')
                    ->type('email', 'admin@admin.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertSee('List');
        });
    }
    public function test_add_member()
    {
        $this->browse(function (Browser $browser) {
           $browser->clickLink('Add Member')
                    ->visit('/admin/members/create')
                    ->assertSee('Add Member')
                    ->type('policy_number','222')
                    ->type('passport','1245')
                    ->type('family_name','kyaw')
                    ->type('name','Kyaw Min Thu')
                    ->select('gender','male')
                    ->select('country',1)
                    ->type('email','kyawminthu123@gmail.com')
                    ->keys('#dob', '2017-03-01')
                    ->type('company','test.col.ltd')
                    ->type('phone','0938383838')
                    ->type('address','1 ward ,1 street,thamine,Yangon')
                    ->type('address_current','1 ward ,1 street,thamine,Yangon')
                    ->press('Save')
                    ->visit('/admin/21/user-insurances/create?type=create')
                    ->select('insurance_id',1)
                    ->pause(2000)
                    ->select('assistance_id',1)
                    ->press('Save')
                    ->assertPathIs('/admin/members');
        });
    }
   
}
