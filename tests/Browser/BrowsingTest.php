<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class BrowsingTest extends DuskTestCase
{

    /** @test */
    public function check_if_login_function_is_working()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->assertVisible('@login-button')
                ->assertVisible('@email-input-field')
                ->assertVisible('@password-input-field')
                ->value('@email-input-field', 'admin@admin.com')
                ->value('@password-input-field', '1234')
                ->click('@login-button');
        });
    }
}
